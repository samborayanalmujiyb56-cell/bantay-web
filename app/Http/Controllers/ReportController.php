<?php

namespace App\Http\Controllers;

use App\Models\DiseaseReport;
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

        return back()->with("status", "Report #" . $report->id . " marked as validated.");
    }

    public function reject(DiseaseReport $report)
    {
        $report->update(["status" => "rejected"]);

        return back()->with("status", "Report #" . $report->id . " marked as rejected.");
    }
}