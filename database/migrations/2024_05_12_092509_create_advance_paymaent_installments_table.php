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
        Schema::create('advance_paymaent_installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('financial_month_id');
            $table->foreign('financial_month_id')->references('id')->on('financial_months')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('financial_year_id');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('advance_payment_id');
            $table->foreign('advance_payment_id')->references('id')->on('advance_payments')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('amount',8,2);
            $table->tinyInteger('installment_num');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advance_paymaent_installments');
    }
};
