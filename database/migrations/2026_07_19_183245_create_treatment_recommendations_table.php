<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatment_recommendations', function (Blueprint $table) {
            $table->id();
            $table->string('disease'); // matches disease keys: black_sigatoka, yellow_sigatoka, fusarium_wilt, healthy
            $table->text('recommendation');
            $table->text('preventive_measures')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatment_recommendations');
    }
};