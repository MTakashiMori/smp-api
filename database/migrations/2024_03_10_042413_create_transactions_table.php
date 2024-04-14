<?php

use App\Constants\TransactionsStatusConstants;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('financial_id')->references('id')->on('financials');
            $table->foreignUuid('financial_categories_id')->references('id')->on('financial_categories');
            $table->string('name')->comment('Name of transaction');
            $table->string('description')->nullable()->comment('Description of transaction');
            $table->double('value', 6, 2)->comment('Transaction value');
            $table->string('status')->default(TransactionsStatusConstants::ON_REVIEW)->comment('Transaction status');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
