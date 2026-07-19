<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detection_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disease_image_id')->constrained()->cascadeOnDelete();
            $table->string('disease');
            $table->decimal('confidence', 5, 4);
            $table->string('severity');
            $table->string('model_status')->default('placeholder');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detection_results');
    }
};