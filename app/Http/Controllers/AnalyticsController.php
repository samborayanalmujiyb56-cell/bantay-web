<?php

namespace App\Http\Controllers;

use App\Models\DiseaseReport;
use App\Models\Farm;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $totalFarmers = User::where("role", "farmer")->count();
        $totalFarms = Farm::count();
        $totalReports = DiseaseReport::count();
        $pendingCount = DiseaseReport::where("status", "pending")->count();

        $reportsByStatus = DiseaseReport::select("status", DB::raw("count(*) as total"))
            ->groupBy("status")
            ->pluck("total", "status");

        $reportsByDisease = DiseaseReport::query()
            ->join("detection_results", "disease_reports.id", "=", "detection_results.disease_report_id")
            ->select("detection_results.disease", DB::raw("count(*) as total"))
            ->groupBy("detection_results.disease")
            ->pluck("total", "disease");

        $manualDiagnoses = DiseaseReport::whereNotNull("admin_diagnosis")
            ->select("admin_diagnosis", DB::raw("count(*) as total"))
            ->groupBy("admin_diagnosis")
            ->pluck("total", "admin_diagnosis");

        $combinedDisease = [];
        foreach ($reportsByDisease as $disease => $count) {
            $combinedDisease[$disease] = ($combinedDisease[$disease] ?? 0) + $count;
        }
        foreach ($manualDiagnoses as $disease => $count) {
            $combinedDisease[$disease] = ($combinedDisease[$disease] ?? 0) + $count;
        }

        $reportsByMonth = DiseaseReport::select(
                DB::raw("to_char(created_at, 'YYYY-MM') as month"),
                DB::raw("count(*) as total")
            )
            ->where("created_at", ">=", now()->subMonths(6))
            ->groupBy("month")
            ->orderBy("month")
            ->pluck("total", "month");

        $topBarangays = DiseaseReport::query()
            ->join("farms", "disease_reports.farm_id", "=", "farms.id")
            ->select("farms.barangay", DB::raw("count(*) as total"))
            ->groupBy("farms.barangay")
            ->orderByDesc("total")
            ->limit(5)
            ->pluck("total", "barangay");

        return view("dashboard", [
            "totalFarmers" => $totalFarmers,
            "totalFarms" => $totalFarms,
            "totalReports" => $totalReports,
            "pendingCount" => $pendingCount,
            "reportsByStatus" => $reportsByStatus,
            "reportsByDisease" => $combinedDisease,
            "reportsByMonth" => $reportsByMonth,
            "topBarangays" => $topBarangays,
        ]);
    }
}