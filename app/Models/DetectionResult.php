<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetectionResult extends Model
{
    protected $fillable = ['disease_image_id', 'disease', 'confidence', 'severity', 'model_status'];

    protected function casts(): array
    {
        return ['confidence' => 'decimal:4'];
    }

    public function diseaseImage(): BelongsTo
    {
        return $this->belongsTo(DiseaseImage::class);
    }
}