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
        Schema::create('supplier_invoice_items', function (Blueprint $table) {
             $table->increments('id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            // $table->unsignedBigInteger('unit_id');
            // $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->string('unit',100);
            $table->string('product_name_ar',255);
            $table->string('product_name_en',255)->nullable();
            $table->string('product_code',255);
            $table->unsignedBigInteger('supplier_invoice_id');
            $table->foreign('supplier_invoice_id')->references('id')->on('supplier_invoices')->onDelete('cascade');
            $table->decimal('qty',12,2)->default(1);
            $table->decimal('purchase_price')->nullable();
            $table->decimal('sale_price');
            $table->decimal('wholesale_inc_vat')->nullable();
            $table->decimal('tax_value')->nullable();
            $table->decimal('total',10,2)->default(0);
            $table->decimal('inventory_balance',10,2)->default(0);
            $table->string('batch_num')->nullable()->comment('رقم التشغيلة');
            $table->tinyInteger('return_status')->nullable();
            $table->tinyInteger('last_return_qty')->nullable()->comment('اخر كمية مردودة');
            $table->enum('return_payment_type',['cash','by_installments','by_check'])->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_invoice_items');
    }
};
