<?php

namespace App\Modules\DiseaseDetection\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetectionResult;
use App\Models\DiseaseReport;
use App\Models\Farm;
use App\Modules\DiseaseDetection\Services\AiDetectionClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiseaseDetectionController extends Controller
{
    public function __construct(protected AiDetectionClient $aiDetectionClient)
    {
    }

    public function history(Request $request)
    {
        $reports = DiseaseReport::with(["farm", "detectionResult"])
            ->where("user_id", $request->user()->id)
            ->latest()
            ->get();

        return response()->json($reports);
    }

    public function detect(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "farm_id" => ["required", "exists:farms,id"],
            "image" => ["required", "image", "max:10240"],
            "latitude" => ["required", "numeric", "between:-90,90"],
            "longitude" => ["required", "numeric", "between:-180,180"],
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $farm = Farm::findOrFail($request->farm_id);

        if ($farm->user_id !== $request->user()->id) {
            return response()->json(["message" => "Forbidden."], 403);
        }

        $path = $request->file("image")->store("disease-reports", "public");

        $report = DiseaseReport::create([
            "farm_id" => $farm->id,
            "user_id" => $request->user()->id,
            "report_type" => "ai",
            "status" => "pending",
            "image_path" => $path,
            "latitude" => $request->latitude,
            "longitude" => $request->longitude,
        ]);

        try {
            $prediction = $this->aiDetectionClient->detect($request->file("image"));
        } catch (\RuntimeException $e) {
            return response()->json(["message" => "AI service unavailable. Please try again."], 503);
        }

        $result = DetectionResult::create([
            "disease_report_id" => $report->id,
            "disease" => $prediction["disease"],
            "confidence" => $prediction["confidence"],
            "severity" => $prediction["severity"],
            "model_status" => $prediction["model_status"] ?? "placeholder",
        ]);

        return response()->json([
            "disease_report" => $report,
            "result" => $result,
        ], 201);
    }

    public function manualReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "farm_id" => ["required", "exists:farms,id"],
            "image" => ["required", "image", "max:10240"],
            "latitude" => ["required", "numeric", "between:-90,90"],
            "longitude" => ["required", "numeric", "between:-180,180"],
            "notes" => ["required", "string", "max:1000"],
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $farm = Farm::findOrFail($request->farm_id);

        if ($farm->user_id !== $request->user()->id) {
            return response()->json(["message" => "Forbidden."], 403);
        }

        $path = $request->file("image")->store("disease-reports", "public");

        $report = DiseaseReport::create([
            "farm_id" => $farm->id,
            "user_id" => $request->user()->id,
            "report_type" => "manual",
            "status" => "pending",
            "image_path" => $path,
            "latitude" => $request->latitude,
            "longitude" => $request->longitude,
            "notes" => $request->notes,
        ]);

        return response()->json(["disease_report" => $report], 201);
    }
}