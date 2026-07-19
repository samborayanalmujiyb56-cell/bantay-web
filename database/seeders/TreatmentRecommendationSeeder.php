<?php

namespace Database\Seeders;

use App\Models\TreatmentRecommendation;
use Illuminate\Database\Seeder;

class TreatmentRecommendationSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                "disease" => "black_sigatoka",
                "recommendation" => "Apply recommended fungicide (e.g. propiconazole or mancozeb-based) on a rotation schedule. Remove and destroy heavily infected leaves to reduce spore spread.",
                "preventive_measures" => "Improve plantation drainage and spacing for better airflow. Avoid overhead irrigation. Regularly monitor lower leaves where infection typically starts.",
            ],
            [
                "disease" => "yellow_sigatoka",
                "recommendation" => "Apply systemic fungicide at early symptom onset. Prune and remove affected leaves promptly to limit spread.",
                "preventive_measures" => "Maintain proper plant spacing and remove weeds that increase humidity. Rotate fungicide types to prevent resistance buildup.",
            ],
            [
                "disease" => "fusarium_wilt",
                "recommendation" => "There is no effective chemical cure once infected. Remove and destroy infected plants immediately, including root systems, to prevent soil contamination spread.",
                "preventive_measures" => "Use disease-free planting material and resistant banana varieties where available. Avoid moving soil or tools between infected and healthy areas. Practice strict field sanitation.",
            ],
            [
                "disease" => "healthy",
                "recommendation" => "No treatment needed.",
                "preventive_measures" => "Continue routine monitoring, proper fertilization, and good field sanitation to maintain plant health.",
            ],
        ];

        foreach ($data as $item) {
            TreatmentRecommendation::updateOrCreate(["disease" => $item["disease"]], $item);
        }
    }
}