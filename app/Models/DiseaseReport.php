<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DiseaseReport extends Model
{
    protected $table = "disease_reports";

    protected $fillable = [
        "farm_id",
        "user_id",
        "report_type",
        "status",
        "image_path",
        "latitude",
        "longitude",
        "notes",
    ];

    protected function casts(): array
    {
        return [
            "latitude" => "decimal:7",
            "longitude" => "decimal:7",
        ];
    }

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detectionResult(): HasOne
    {
        return $this->hasOne(DetectionResult::class);
    }
}