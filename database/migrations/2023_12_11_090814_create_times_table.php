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
            $table->foreignId('dayId')->constrained('days')->cascadeOnDelete();
            $table->date('startTime');
            $table->date('endTime');
            $table->enum('status',[0,1]);
=======
>>>>>>> 9f4de87ea81fac892fa8094389c4baccadc8f168
            $table->id();
            $table->foreignId('userId')->constrained('users')->cascadeOnDelete();
            $table->foreignId('dayId')->nullable()->constrained('days')->cascadeOnDelete();
            $table->string('startTime')->nullable();
            $table->string('endTime')->nullable();
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
