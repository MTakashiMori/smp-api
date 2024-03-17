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
        Schema::create('users', function (Blueprint $table) {
<<<<<<< HEAD
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
=======
            $table->uuid('id');
            $table->string('name')->comment('User name');
            $table->string('email')->unique()->comment('User email');
>>>>>>> 7697ef8bfebcd35431649573b32fa369a71e60e9
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment('User password');
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
