<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Hapus kolom kelas lama jika ada
            if (Schema::hasColumn('siswas', 'kelas')) {
                $table->dropColumn('kelas');
            }

            // Tambah foreign key kelas_id
            $table->unsignedBigInteger('kelas_id')->nullable()->after('id');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('set null');
        });
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
