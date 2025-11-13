<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('photo_path')->nullable()->after('notes');
            $table->string('location_latitude')->nullable()->after('photo_path');
            $table->string('location_longitude')->nullable()->after('location_latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['photo_path', 'location_latitude', 'location_longitude']);
        });
    }
};
