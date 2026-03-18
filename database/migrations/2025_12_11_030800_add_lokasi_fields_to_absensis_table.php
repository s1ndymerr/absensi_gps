<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            if (!Schema::hasColumn('absensis', 'latitude')) {
                $table->decimal('latitude', 11, 8)->nullable()->after('jam_masuk');
            }
            if (!Schema::hasColumn('absensis', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('absensis', 'jarak_meter')) {
                $table->float('jarak_meter')->nullable()->after('longitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            if (Schema::hasColumn('absensis', 'latitude')) {
                $table->dropColumn('latitude');
            }
            if (Schema::hasColumn('absensis', 'longitude')) {
                $table->dropColumn('longitude');
            }
            if (Schema::hasColumn('absensis', 'jarak_meter')) {
                $table->dropColumn('jarak_meter');
            }
        });
    }
};
