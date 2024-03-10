<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phoneNumber')->unique();
            $table->date('birthDate');
            $table->string('password');
            $table->enum('role', ['admin', 'player', 'coach']);
            $table->integer('rate')->default(0);
            $table->date('expiration')->default(now()->addMonth());
            $table->text('bio')->nullable();
            $table->double('finance')->default(0);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
