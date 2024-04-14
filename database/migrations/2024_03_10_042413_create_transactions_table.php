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
            $table->id();

            $table->foreignId('financial_id')->constrained();
            $table->foreignId('financial_categories_id')->constrained();
            $table->string('name')->comment('Name of transaction');
            $table->string('description')->nullable()->comment('Description of transaction');
            $table->double('value', 6, 2)->comment('Transaction value');
            $table->string('status')->default(TransactionsStatusConstants::ON_REVIEW)->comment('Transaction status');

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
