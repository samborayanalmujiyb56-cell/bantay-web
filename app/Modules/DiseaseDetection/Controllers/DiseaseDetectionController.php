<?php

namespace App\Modules\DiseaseDetection\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetectionResult;
use App\Models\DiseaseImage;
use App\Models\Farm;
use App\Modules\DiseaseDetection\Services\AiDetectionClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiseaseDetectionController extends Controller
{
    public function __construct(protected AiDetectionClient $aiDetectionClient)
    {
    }

    public function detect(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'farm_id' => ['required', 'exists:farms,id'],
            'image' => ['required', 'image', 'max:10240'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $farm = Farm::findOrFail($request->farm_id);

        if ($farm->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $path = $request->file('image')->store('disease-images', 'public');

        $diseaseImage = DiseaseImage::create([
            'farm_id' => $farm->id,
            'user_id' => $request->user()->id,
            'image_path' => $path,
        ]);

        try {
            $prediction = $this->aiDetectionClient->detect($request->file('image'));
        } catch (\RuntimeException $e) {
            return response()->json(['message' => 'AI service unavailable. Please try again.'], 503);
        }

        $result = DetectionResult::create([
            'disease_image_id' => $diseaseImage->id,
            'disease' => $prediction['disease'],
            'confidence' => $prediction['confidence'],
            'severity' => $prediction['severity'],
            'model_status' => $prediction['model_status'] ?? 'placeholder',
        ]);

        return response()->json([
            'disease_image' => $diseaseImage,
            'result' => $result,
        ], 201);
    }
}