<?php

namespace App\Http\Controllers;

use App\Models\DiseaseReport;
use App\Models\Notification;
use App\Models\TreatmentRecommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get("status", "pending");

        $reports = DiseaseReport::with(["farm", "user", "detectionResult"])
            ->when($status !== "all", fn ($query) => $query->where("status", $status))
            ->latest()
            ->paginate(15);

        return view("reports.index", [
            "reports" => $reports,
            "activeStatus" => $status,
            "diseaseOptions" => TreatmentRecommendation::pluck("disease"),
        ]);
    }

    public function validateReport(Request $request, DiseaseReport $report)
    {
        $isManual = $report->report_type === "manual";

        $validator = Validator::make($request->all(), [
            "admin_diagnosis" => [$isManual ? "required" : "nullable", "string"],
            "admin_notes" => ["nullable", "string", "max:1000"],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $diagnosis = $request->admin_diagnosis ?: ($report->detectionResult->disease ?? null);

        $report->update([
            "status" => "validated",
            "admin_diagnosis" => $diagnosis,
            "admin_notes" => $request->admin_notes,
        ]);

        $treatment = $diagnosis ? TreatmentRecommendation::where("disease", $diagnosis)->first() : null;

        $messageParts = [];
        $messageParts[] = "Your report for {$report->farm->name} has been validated.";

        if ($diagnosis) {
            $label = ucwords(str_replace("_", " ", $diagnosis));
            $messageParts[] = "Diagnosis: {$label}.";
        }

        if ($treatment) {
            $messageParts[] = "Recommendation: {$treatment->recommendation}";
        }

        if ($request->admin_notes) {
            $messageParts[] = "Note from MAO: {$request->admin_notes}";
        }

        Notification::create([
            "user_id" => $report->user_id,
            "disease_report_id" => $report->id,
            "title" => "Report Validated",
            "message" => implode(" ", $messageParts),
            "status" => "unread",
        ]);

        return back()->with("status", "Report #" . $report->id . " marked as validated.");
    }

    public function reject(Request $request, DiseaseReport $report)
    {
        $request->validate([
            "admin_notes" => ["nullable", "string", "max:1000"],
        ]);

        $report->update([
            "status" => "rejected",
            "admin_notes" => $request->admin_notes,
        ]);

        $message = "Your report for {$report->farm->name} was reviewed but rejected by the MAO.";
        if ($request->admin_notes) {
            $message .= " Reason: {$request->admin_notes}";
        } else {
            $message .= " Please contact your local agricultural office for details.";
        }

        Notification::create([
            "user_id" => $report->user_id,
            "disease_report_id" => $report->id,
            "title" => "Report Rejected",
            "message" => $message,
            "status" => "unread",
        ]);

        return back()->with("status", "Report #" . $report->id . " marked as rejected.");
    }
}