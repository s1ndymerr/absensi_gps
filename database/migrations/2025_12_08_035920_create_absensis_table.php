<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->date('tanggal');

            // hadir / izin / sakit
            $table->enum('status', ['hadir', 'izin', 'sakit']);

            // hanya untuk izin & sakit
            $table->enum('approval_status', ['pending', 'disetujui', 'ditolak'])
                  ->nullable();

            $table->text('alasan')->nullable();

            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();


            $table->decimal('latitude', 11, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->double('jarak_meter')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
