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
        Schema::create('party_sponsors', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('party_id')->references('id')->on('parties');
            $table->foreignUuid('sponsor_id')->references('id')->on('sponsors');

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_sponsors');
    }
};
