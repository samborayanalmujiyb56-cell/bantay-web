<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advisories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('message');
            $table->string('category')->default('general'); // general | weather | outbreak | tip
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advisories');
    }
};