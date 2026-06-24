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
        Schema::create('role_users', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignUuid('role_id')->references('id')->on('roles')->cascadeOnDelete();
            
            $table->foreignUuid('party_id')->nullable()->references('id')->on('parties');
            $table->index(['party_id', 'user_id']);
            $table->index(['party_id', 'role_id']);
            $table->unique(['user_id', 'role_id', 'party_id'], 'role_users_user_role_party_unique');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_users');
    }
};
