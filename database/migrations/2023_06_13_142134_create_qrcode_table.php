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

            $table->string('id_angkatan');
            $table->string('id_kelas');
            $table->string('id_matkul');


            $table->string('nama');
            $table->integer('teachingId');
            $table->integer('periodId');
            $table->string('date');
            $table->integer('meetingTo');
            $table->integer('tahun');
            $table->integer('bulan');
            $table->integer('tanggal');
            $table->integer('jam');
            $table->integer('menit');
            $table->integer('detik');
            $table->longText('uniqueCode');

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
