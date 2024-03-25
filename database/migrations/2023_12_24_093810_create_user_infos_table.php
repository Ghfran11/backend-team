<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->enum('gender', ['male', 'female']);
            $table->date('birthDate')->nullable();
            $table->integer('age')->nullable();
            $table->double('weight')->nullable();
            $table->double('waist_measurement')->nullable();
            $table->double('neck')->nullable();
            $table->double('height')->nullable();
            $table->double('BFP')->nullable();
            $table->foreignId('userId')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
