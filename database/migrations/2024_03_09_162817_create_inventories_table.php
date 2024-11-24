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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->decimal('initial_balance',10,2)->defaul(0);
            $table->decimal('inventory_balance',10,2)->defaul(0);
            $table->decimal('in_qty',10,2)->defaul(0);
            $table->decimal('out_qty',10,2)->defaul(0);
            $table->boolean('is_active');
            $table->integer('current_financial_year');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('branch_id' )->unsigned()->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('store_id' )->unsigned()->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->decimal('latest_purchase_price',10,2)->nullable();
            $table->decimal('latest_sale_price',8,2)->nullable();
            // $table->unsignedBigInteger('supplier_id' )->unsigned();
            // $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->string('notes')->nullable();
            $table->morphs('inventorable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
