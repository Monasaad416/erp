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
        Schema::create('sales_reports', function (Blueprint $table) {
            $table->id();
            $table->string('customer_inv_num', 50);
            $table->date('customer_inv_date_time');
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->decimal('tax_value',10,2)->nullable()->default(0);
            $table->decimal('tax_after_discount',8,2)->nullable()->default(0);
            $table->decimal('total_before_discount',12,2)->nullable()->default(0);
            $table->decimal('discount_percentage',12,2)->nullable();
            $table->decimal('total_after_discount',12,2)->nullable()->default(0);
            $table->text('notes')->nullable();
            $table->enum('payment_type',['visa','cash'])->nullable();
            $table->tinyInteger('return_status')->nullable();
            $table->unsignedBigInteger('branch')->nullable();
            $table->boolean('is_pending')->nullable();
            $table->foreign('branch')->references('id')->on('branches')->onDelete('set null');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_reports');
    }
};
