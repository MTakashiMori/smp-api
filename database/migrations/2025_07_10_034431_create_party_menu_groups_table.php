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
        Schema::create('party_menu_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('party_menu_id')->references('id')->on('party_menus');
            $table->string('name')->comment('Party menu group name');
            $table->string('icon')->nullable()->comment('Party menu group icon');
            $table->string('color')->nullable()->comment('Party menu group color in hex');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_menu_groups');
    }
};
