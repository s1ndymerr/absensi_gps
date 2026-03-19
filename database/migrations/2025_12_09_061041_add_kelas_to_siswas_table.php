<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
        {
            if (!Schema::hasColumn('siswas', 'kelas_id')) {
                Schema::table('siswas', function (Blueprint $table) {
                    $table->unsignedBigInteger('kelas_id')->nullable()->after('id');
                });
            }
        }
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // drop foreign key
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');

            // kembalikan kolom lama jika ingin rollback
            $table->string('kelas')->nullable();
        });
    }
};
