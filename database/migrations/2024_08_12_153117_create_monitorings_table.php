<?php

use App\Models\Customer;
use App\Models\Genset;
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
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('genset_id')
                ->references('id')
                ->on('gensets');
            $table->string('order_id')->references('order_id')->on('transactions')->nullable();
            $table->foreignId('operator_id')->nullable();
            $table->date('tgl_cek');
            $table->text('foto_rental')->nullable();
            $table->text('daily_report')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitorings');
    }
};
