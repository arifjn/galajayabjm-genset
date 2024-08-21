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
        Schema::create('gensets', function (Blueprint $table) {
            $table->id();
            $table->string('no_genset')->unique();

            $table->string('brand_engine');
            $table->string('tipe_engine');
            $table->string('sn_engine')->nullable();
            $table->integer('no_silinder')->nullable();
            $table->integer('kecepatan')->nullable();
            $table->string('bore_stroke')->nullable();
            $table->integer('piston')->nullable();
            $table->string('pendingin')->nullable();
            $table->integer('kaps_oli')->nullable();
            $table->string('bahan_bakar')->nullable();

            $table->string('brand_generator');
            $table->string('tipe_generator');
            $table->string('sn_generator')->nullable();
            $table->integer('kapasitas');
            $table->string('insul_class')->nullable();
            $table->string('sist_eksitasi')->nullable();
            $table->integer('frekuensi')->nullable();
            $table->string('regulator_tegangan')->nullable();
            $table->string('voltase')->nullable();
            $table->integer('phase')->nullable();

            $table->string('tipe_genset');
            $table->text('images_genset');
            $table->text('spek_genset')->nullable();
            $table->string('status_genset')->default('ready');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gensets');
    }
};
