<?php

namespace App\Modules\FarmManagement\Services;

use App\Models\Farm;
use App\Models\ProductionRecord;
use App\Models\User;

class FarmService
{
    public function createFarm(User $user, array $data): Farm
    {
        return $user->farms()->create([
            'name' => $data['name'],
            'barangay' => $data['barangay'],
            'area_size' => $data['area_size'],
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
        ]);
    }

    public function updateFarm(Farm $farm, array $data): Farm
    {
        $farm->update($data);
        return $farm->fresh();
    }

    public function addProductionRecord(Farm $farm, array $data): ProductionRecord
    {
        return $farm->productionRecords()->create([
            'variety' => $data['variety'],
            'planting_date' => $data['planting_date'],
            'expected_harvest_date' => $data['expected_harvest_date'],
        ]);
    }
}