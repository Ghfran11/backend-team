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
<<<<<<< HEAD
            $table->foreignId('userId')->constrained('users')->cascadeOnDelete();
            $table->date('startTime');
            $table->date('endTime');
=======
            $table->foreignId('playerId')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('coachId')->nullable()->constrained('users')->cascadeOnDelete();
            $table->dateTime('startTime');
            $table->dateTime('endTime');
>>>>>>> c7a182187fcf5d51d56d60cf8afdd4de3ea5a68e
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
