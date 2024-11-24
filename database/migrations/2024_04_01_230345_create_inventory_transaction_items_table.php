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
        Schema::create('inventory_transaction_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_transaction_id' )->unsigned();
            $table->foreign('inventory_transaction_id')->references('id')->on('inventory_transactions')->onDelete('cascade');
            $table->unsignedBigInteger('product_id' )->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->decimal('qty',10,2);
            $table->string('product_code',100);
            $table->string('product_name_ar',255);
            $table->string('product_name_en',255)->nullable();
            $table->decimal('accepted_qty',10,2)->default(0);
            $table->string('unit',100);
            $table->decimal('unit_price');
            $table->decimal('total_price',12,2);
            $table->decimal('from_branch_new_balance');
            $table->decimal('to_branch_new_balance');
            $table->enum('approval',['partially_accepted','rejected','accepted','pending']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transaction_items');
    }
};
