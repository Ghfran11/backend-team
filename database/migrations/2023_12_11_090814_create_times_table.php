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
        Schema::create('times', function (Blueprint $table) {
            $table->foreignId('playerId')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('coachId')->nullable()->constrained('users')->cascadeOnDelete();
            $table->dateTime('startTime');
            $table->dateTime('endTime');
            $table->foreignId('dayId')->constrained('days')->cascadeOnDelete();
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('times');
    }
};
