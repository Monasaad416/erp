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
        Schema::create('supplier_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('unit',100);
            $table->string('product_name_ar',255);
            $table->string('product_name_en',255)->nullable();
            $table->string('product_code',255);
            $table->unsignedBigInteger('supplier_invoice_id');
            $table->foreign('supplier_invoice_id')->references('id')->on('supplier_invoices')->onDelete('cascade');
            $table->decimal('purchase_price');
            $table->decimal('tax_value');
            $table->decimal('total',10,2);
            $table->string('batch_num')->nullable()->comment('رقم التشغيلة');
            $table->tinyInteger('return_status');
            $table->decimal('return_qty',12,2);
            $table->enum('return_payment_type',['cash','by_installments','by_check']);
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');
            $table->string('check_num')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_returns');
    }
};
