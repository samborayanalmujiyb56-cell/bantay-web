<?php

namespace App\Http\Controllers;

use App\Models\User;

class FarmerController extends Controller
{
    public function index()
    {
        $farmers = User::where("role", "farmer")
            ->withCount(["farms", "diseaseReports"])
            ->with("farms")
            ->latest()
            ->paginate(10);

        return view("farmers.index", [
            "farmers" => $farmers,
        ]);
    }

    public function show(User $farmer)
    {
        abort_if($farmer->role !== "farmer", 404);

        $farmer->load(["farms.productionRecords", "diseaseReports.detectionResult"]);

        return view("farmers.show", [
            "farmer" => $farmer,
        ]);
    }
}