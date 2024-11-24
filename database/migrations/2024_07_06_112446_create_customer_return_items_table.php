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
        Schema::create('customer_return_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_return_id')->nullable();
            $table->foreign('customer_return_id')->references('id')->on('customer_returns')->onDelete('cascade');
            $table->string('customer_inv_num',50)->nullable();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('unit',100);
            $table->string('product_name_ar',255);
            $table->string('product_name_en',255)->nullable();
            $table->string('product_code',255);
            $table->decimal('sale_price')->nullable();
            $table->decimal('total_without_tax',10,2)->default(0);
            $table->decimal('tax')->default(0);
            $table->decimal('total_with_tax',10,2)->default(0);
            $table->tinyInteger('return_status')->nullable();
            $table->decimal('return_qty',8,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_return_items');
    }
};
