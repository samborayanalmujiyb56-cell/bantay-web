<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->cascadeOnDelete();
            $table->string('variety');
            $table->date('planting_date');
            $table->date('expected_harvest_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_records');
    }
};