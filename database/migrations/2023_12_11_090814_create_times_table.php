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
            $table->foreignId('dayId')->constrained('days')->cascadeOnDelete();
            $table->date('startTime');
            $table->date('endTime');
            $table->enum('status',[0,1]);
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
