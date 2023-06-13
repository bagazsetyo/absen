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
        Schema::create('qrcode', function (Blueprint $table) {
            $table->id();

            $table->integer('id_angkatan');
            $table->integer('id_kelas');
            $table->integer('id_matkul');

            $table->integer('teachingId');
            $table->integer('periodId');
            $table->integer('date');
            $table->integer('meetingTo');
            $table->integer('tahu');
            $table->integer('bulan');
            $table->integer('tanggal');
            $table->integer('jam');
            $table->integer('menit');
            $table->integer('detik');
            $table->string('uniqueCode');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qrcode');
    }
};
