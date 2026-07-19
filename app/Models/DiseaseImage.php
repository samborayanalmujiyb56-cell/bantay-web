<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DiseaseImage extends Model
{
    protected $fillable = ['farm_id', 'user_id', 'image_path'];

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