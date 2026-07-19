<?php

namespace App\Http\Controllers;

use App\Models\DiseaseReport;

class SurveillanceController extends Controller
{
    public function map()
    {
        $reports = DiseaseReport::with(["farm", "user", "detectionResult"])
            ->whereNotNull("latitude")
            ->whereNotNull("longitude")
            ->get()
            ->map(function ($report) {
                return [
                    "id" => $report->id,
                    "lat" => (float) $report->latitude,
                    "lng" => (float) $report->longitude,
                    "farm" => $report->farm->name ?? "Unknown",
                    "farmer" => trim(($report->user->first_name ?? "") . " " . ($report->user->last_name ?? "")),
                    "type" => $report->report_type,
                    "status" => $report->status,
                    "disease" => $report->detectionResult->disease ?? null,
                    "severity" => $report->detectionResult->severity ?? null,
                    "notes" => $report->notes,
                    "created_at" => $report->created_at->format("M d, Y"),
                ];
            });

        return view("surveillance.map", [
            "reports" => $reports,
        ]);
    }
}