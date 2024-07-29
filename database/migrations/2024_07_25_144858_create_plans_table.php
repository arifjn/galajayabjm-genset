<?php

use App\Models\Genset;
use App\Models\Transaction;
use App\Models\User;
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
            $table->foreignIdFor(Transaction::class, 'order_id')
                ->nullable();
            $table->string('jobdesk');
            $table->date('tanggal_job');
            $table->date('tanggal_job_selesai');
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
