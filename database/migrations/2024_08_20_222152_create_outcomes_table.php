<?php

use App\Models\Plan;
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
        Schema::create('outcomes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Plan::class)
                ->nullable();
            $table->string('lainnya')->nullable();
            $table->decimal('biaya_lainnya', 10, 2)->nullable();
            $table->decimal('upd', 10, 2)->nullable();
            $table->decimal('biaya_service', 10, 2)->nullable();
            $table->decimal('outcome', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outcomes');
    }
};
