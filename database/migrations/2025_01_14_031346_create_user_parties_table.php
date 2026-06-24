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
        Schema::create('user_parties', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->foreignUuid('party_id')->references('id')->on('parties');
            $table->unique(['user_id', 'party_id'], 'user_parties_user_party_unique');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_parties');
    }
};
