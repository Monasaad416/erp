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
        Schema::create('supplier_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('supp_inv_num');
            $table->string('serial_num', 50);
            $table->timestamp('supp_inv_date_time');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->decimal('discount_value')->nullable();
            $table->decimal('discount_percentage')->nullable();
            $table->decimal('paid_amount',12,2)->nullable();
            $table->decimal('tax_value')->nullable();
            $table->decimal('tax_after_discount',8,2)->nullable()->default(0);
            $table->decimal('total_before_discount',12,2)->default(0);
            $table->decimal('total_after_discount',12,2)->default(0);
            $table->decimal('deserved_amount',12,2)->default(0);
            $table->decimal('transportation_fees',12,2)->comment('مصاريف نقل البضاعة')->nulluble();
            $table->enum('payment_type',['cash','by_installments','by_check'])->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('return_status')->nullable();
            $table->enum('return_payment_type',['cash','by_installments','by_check'])->nullable();
            $table->text('notes')->nullable();
            $table->date('payment_date')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->decimal('supp_balance_before_invoice',12,2)->default(0);
            $table->decimal('supp_balance_after_invoice',12,2)->default(0);
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->boolean('is_pending')->default(false);
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');
            $table->string('check_num')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_invoices');
    }
};
