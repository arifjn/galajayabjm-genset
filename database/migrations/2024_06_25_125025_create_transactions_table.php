<?php

use App\Models\Customer;
use App\Models\Genset;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignIdFor(Customer::class)
                ->constrained();
            $table->foreignIdFor(Genset::class)
                ->nullable();

            $table->foreignId('sales_id')->nullable();

            $table->string('subject');
            $table->date('tgl_sewa')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->boolean('operator')->default(0);
            $table->text('site')->nullable();
            $table->string('kapasitas')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('status_transaksi')->nullable();

            $table->text('bukti_tf')->nullable();
            $table->integer('ppn')->nullable();
            $table->decimal('harga', 10, 2)->nullable();
            $table->decimal('mob_demob', 10, 2)->nullable();
            $table->decimal('biaya_operator', 10, 2)->nullable();
            $table->decimal('sub_total', 10, 2)->nullable();
            $table->decimal('grand_total', 10, 2)->nullable();

            $table->integer('overtime')->nullable();
            $table->decimal('denda', 10, 2)->nullable();
            $table->text('tf_denda')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
