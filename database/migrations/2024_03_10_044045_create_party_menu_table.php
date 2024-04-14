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
        Schema::create('party_menus', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('party_id')->references('id')->on('parties');

            $table->string('label')->default('Geral')->comment('Menu label');

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_menus');
    }
};
