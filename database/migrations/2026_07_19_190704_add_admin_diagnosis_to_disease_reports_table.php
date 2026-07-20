<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disease_reports', function (Blueprint $table) {
            $table->string('admin_diagnosis')->nullable()->after('status');
            $table->text('admin_notes')->nullable()->after('admin_diagnosis');
        });
    }

    public function down(): void
    {
        Schema::table('disease_reports', function (Blueprint $table) {
            $table->dropColumn(['admin_diagnosis', 'admin_notes']);
        });
    }
};