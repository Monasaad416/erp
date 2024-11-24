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
        Schema::create('customer_debit_note_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_debit_note_id')->nullable();
            $table->unsignedBigInteger('customer_invoice_id')->nullable();
            $table->string('customer_inv_num',50)->nullable();
            $table->foreign('customer_debit_note_id')->references('id')->on('customer_debit_notes')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('unit',100);
            $table->string('product_name_ar',255);
            $table->string('product_name_en',255)->nullable();
            $table->string('product_code',255);
            $table->decimal('sale_price')->nullable();
            $table->decimal('total_without_tax',8,2)->default(0);
            $table->decimal('tax')->default(0);
            $table->decimal('total_with_tax',8,2)->default(0);
            $table->decimal('qty',8,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_debit_note_items');
    }
};
