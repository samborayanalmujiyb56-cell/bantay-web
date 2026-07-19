<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('disease_images', 'disease_reports');

        Schema::table('disease_reports', function (Blueprint $table) {
            $table->string('report_type')->default('ai')->after('user_id'); // ai | manual
            $table->string('status')->default('pending')->after('report_type'); // pending | validated | rejected
            $table->decimal('latitude', 10, 7)->nullable()->after('image_path');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->text('notes')->nullable()->after('longitude');
        });

        // Rename FK column on detection_results to match the renamed parent table
        DB::statement('ALTER TABLE detection_results RENAME COLUMN disease_image_id TO disease_report_id');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE detection_results RENAME COLUMN disease_report_id TO disease_image_id');

        Schema::table('disease_reports', function (Blueprint $table) {
            $table->dropColumn(['report_type', 'status', 'latitude', 'longitude', 'notes']);
        });

        Schema::rename('disease_reports', 'disease_images');
    }
};