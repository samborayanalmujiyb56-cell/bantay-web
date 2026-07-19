<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentRecommendation extends Model
{
    protected $fillable = ["disease", "recommendation", "preventive_measures"];
}