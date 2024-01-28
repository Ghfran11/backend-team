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
            $table->foreignId('userId')->constrained('users')->cascadeOnDelete();
            $table->foreignId('dayId')->nullable()->constrained('days')->cascadeOnDelete();
            $table->dateTime('startTime');
            $table->dateTime('endTime')->nullable();
            $table->enum('status',[0,1]);
            $table->id();
            $table->boolean('isCoach');
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
