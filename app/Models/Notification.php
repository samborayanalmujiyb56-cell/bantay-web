<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = ["user_id", "disease_report_id", "title", "message", "status"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function diseaseReport(): BelongsTo
    {
        return $this->belongsTo(DiseaseReport::class);
    }
}