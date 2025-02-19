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
            $table->uuid('id')->primary();
            $table->string('name')->comment('User name');
            $table->string('email')->unique()->comment('User email');
            $table->string('cpf', 14)->unique()->comment('User cpf');
            $table->string('address')->comment('User address');
            $table->string('telephone')->comment('User telephone');
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
