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
        Schema::create('customer_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('unit',100);
            $table->string('product_name_ar',255);
            $table->string('product_name_en',255)->nullable();
            $table->string('product_code',255);
            $table->unsignedBigInteger('customer_invoice_id');
            $table->foreign('customer_invoice_id')->references('id')->on('customer_invoices')->onDelete('cascade');
            $table->decimal('qty',12,2)->default(1);
            $table->decimal('sale_price')->nullable();
            $table->decimal('total_without_tax',8,2)->default(0);
            $table->decimal('tax',8,2)->default(0);
            $table->decimal('total_with_tax',8,2)->default(0);
            $table->decimal('total_commission_rate',8,2)->default(0);
            $table->tinyInteger('return_status')->nullable();
            $table->decimal('return_qty',8,2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_invoice_items');
    }
};
