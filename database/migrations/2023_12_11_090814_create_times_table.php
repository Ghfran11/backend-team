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
            $table->id();
<<<<<<< HEAD
            $table->enum('status',[0,1]);
            $table->foreignId('userId')->constrained('users')->cascadeOnDelete();
            $table->foreignId('dayId')->nullable()->constrained('days')->cascadeOnDelete();
            $table->string('startTime')->nullable();
            $table->string('endTime')->nullable();
=======
>>>>>>> 549af65618835444f8eaf028b92af7db557c9f7a
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
