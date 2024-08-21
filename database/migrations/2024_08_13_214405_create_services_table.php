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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('genset_id')->references('id')->on('gensets');
            $table->string('order_id')->references('order_id')->on('transactions')->nullable();
            $table->date('tgl_cek');
            $table->text('foto_service')->nullable();
            $table->text('service_report')->nullable();
            $table->text('part_request')->nullable();
            $table->text('check_list')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
