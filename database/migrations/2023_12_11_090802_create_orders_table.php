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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coachId')->constrained('users')->cascadeOnDelete();
            $table->foreignId('playerId')->constrained('users')->cascadeOnDelete();
<<<<<<< HEAD
            $table->enum('status',['waiting','accepted','rejected']);
=======
>>>>>>> c7a182187fcf5d51d56d60cf8afdd4de3ea5a68e
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
