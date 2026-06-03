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
            $table->string('status')->comment('Party status name')->default('active');
            // active fulfilled scheduled rejected imported

            $table->foreignUuid('address_id')->references('id')->on('addresses');

            $table->softDeletes();

            $table->timestamps();
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->foreignUuid('party_id')->nullable()->after('id')->references('id')->on('parties');
            $table->index(['party_id', 'name']);
        });

        Schema::table('role_users', function (Blueprint $table) {
            $table->foreignUuid('party_id')->nullable()->after('role_id')->references('id')->on('parties');
            $table->index(['party_id', 'user_id']);
            $table->index(['party_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_users', function (Blueprint $table) {
            $table->dropForeign(['party_id']);
            $table->dropIndex(['party_id', 'user_id']);
            $table->dropIndex(['party_id', 'role_id']);
            $table->dropColumn('party_id');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['party_id']);
            $table->dropIndex(['party_id', 'name']);
            $table->dropColumn('party_id');
        });

        Schema::dropIfExists('parties');
    }
};
