<?php

use App\Models\Genset;
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
        Schema::create('genset_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Genset::class)
                ->nullable();
            $table->foreignIdFor(Plan::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genset_plan');
    }
};
