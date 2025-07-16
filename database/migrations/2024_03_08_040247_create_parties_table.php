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
        Schema::create('parties', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name')->comment('Party name');
            $table->date('start_date')->comment('Party start date');
            $table->date('end_date')->comment('Party end date');
            $table->string('reference')->comment('Party reference name');
//            $table->string('address')->comment('Party address');
            $table->foreignUuid('address_id')->references('id')->on('addresses');

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
