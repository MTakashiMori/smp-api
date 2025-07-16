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
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('address')->comment('Address');
            $table->string('complement')->comment('Address complement');
            $table->string('cep')->comment('Zip code');
            $table->string('neighborhood')->comment('Neighborhood');
            $table->string('city')->comment('City');
            $table->string('uf')->comment('State/UF');

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
