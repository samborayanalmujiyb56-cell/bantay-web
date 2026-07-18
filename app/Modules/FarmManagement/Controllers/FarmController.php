<?php

namespace App\Modules\FarmManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Modules\FarmManagement\Services\FarmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FarmController extends Controller
{
    public function __construct(protected FarmService $farmService)
    {
    }

    public function index(Request $request)
    {
        return response()->json(
            $request->user()->farms()->with('productionRecords')->get()
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:150'],
            'barangay' => ['required', 'string', 'max:150'],
            'area_size' => ['required', 'numeric', 'min:0.01'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $farm = $this->farmService->createFarm($request->user(), $validator->validated());

        return response()->json($farm, 201);
    }

    public function update(Request $request, Farm $farm)
    {
        if ($farm->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'string', 'max:150'],
            'barangay' => ['sometimes', 'string', 'max:150'],
            'area_size' => ['sometimes', 'numeric', 'min:0.01'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $farm = $this->farmService->updateFarm($farm, $validator->validated());

        return response()->json($farm);
    }

    public function addProduction(Request $request, Farm $farm)
    {
        if ($farm->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'variety' => ['required', 'string', 'max:100'],
            'planting_date' => ['required', 'date'],
            'expected_harvest_date' => ['required', 'date', 'after:planting_date'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $record = $this->farmService->addProductionRecord($farm, $validator->validated());

        return response()->json($record, 201);
    }
}