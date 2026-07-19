<?php

namespace App\Http\Controllers;

use App\Models\DiseaseReport;
use App\Models\Notification;
use App\Models\TreatmentRecommendation;
use Illuminate\Http\Request;

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
        ]);
    }

    public function validateReport(DiseaseReport $report)
    {
        $report->update(["status" => "validated"]);

        $disease = $report->detectionResult->disease ?? null;
        $treatment = $disease ? TreatmentRecommendation::where("disease", $disease)->first() : null;

        $message = $treatment
            ? "Your report for {$report->farm->name} has been validated. Recommendation: {$treatment->recommendation}"
            : "Your report for {$report->farm->name} has been validated by the MAO.";

        Notification::create([
            "user_id" => $report->user_id,
            "disease_report_id" => $report->id,
            "title" => "Report Validated",
            "message" => $message,
            "status" => "unread",
        ]);

        return back()->with("status", "Report #" . $report->id . " marked as validated.");
    }

    public function reject(DiseaseReport $report)
    {
        $report->update(["status" => "rejected"]);

        Notification::create([
            "user_id" => $report->user_id,
            "disease_report_id" => $report->id,
            "title" => "Report Rejected",
            "message" => "Your report for {$report->farm->name} was reviewed but rejected by the MAO. Please contact your local agricultural office for details.",
            "status" => "unread",
        ]);

        return back()->with("status", "Report #" . $report->id . " marked as rejected.");
    }
}