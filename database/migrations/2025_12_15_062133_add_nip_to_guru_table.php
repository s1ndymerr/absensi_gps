<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
public function up()
{
    if (Schema::hasTable('guru') &&
        !Schema::hasColumn('guru', 'nip')) {

        Schema::table('guru', function (Blueprint $table) {
            $table->string('nip')->nullable();
        });

    }
}

public function down(): void
{
    Schema::table('guru', function (Blueprint $table) {
        $table->dropColumn('nip');
    });
}

};
