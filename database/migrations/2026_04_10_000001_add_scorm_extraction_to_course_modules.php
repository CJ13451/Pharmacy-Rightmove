<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_modules', function (Blueprint $table) {
            // Directory (relative to the public disk root) where the SCORM
            // package has been extracted.
            $table->string('scorm_package_path')->nullable()->after('scorm_package_url');

            // Path (relative to scorm_package_path) to the HTML launch file
            // resolved from imsmanifest.xml.
            $table->string('scorm_entry_path')->nullable()->after('scorm_package_path');
        });
    }

    public function down(): void
    {
        Schema::table('course_modules', function (Blueprint $table) {
            $table->dropColumn(['scorm_package_path', 'scorm_entry_path']);
        });
    }
};
