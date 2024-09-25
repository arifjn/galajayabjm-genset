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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->references('order_id')->on('transactions')->nullable();
            $table->foreignId('operator_id')->nullable();
            $table->string('choose_jobdesk');
            $table->string('jobdesk')->nullable();
            $table->string('alamat')->nullable();
            $table->date('tanggal_job');
            $table->date('tanggal_job_selesai');

            $table->date('tanggal_kembali')->nullable();

            $table->string('status');
            $table->text('keterangan')->nullable();
            $table->string('nama_supir')->nullable();
            $table->string('nohp_supir')->nullable();
            $table->string('jenis_mobil')->nullable();
            $table->string('plat_mobil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
