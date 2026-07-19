<?php

namespace App\Modules\DiseaseDetection\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class AiDetectionClient
{
    public function detect(UploadedFile $image): array
    {
        $baseUrl = config('services.ai_service.url', 'http://127.0.0.1:8001');

        $response = Http::attach(
            'file',
            file_get_contents($image->getRealPath()),
            $image->getClientOriginalName()
        )->post("{$baseUrl}/detect");

        if ($response->failed()) {
            throw new \RuntimeException('AI service request failed: ' . $response->body());
        }

        return $response->json();
    }
}