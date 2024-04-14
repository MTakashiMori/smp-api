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
        Schema::create('party_menu_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('party_menu_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->double('price', 6, 2);
            $table->string('group')->default('geral')->comment('Party Menu group');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_menu_products');
    }
};
