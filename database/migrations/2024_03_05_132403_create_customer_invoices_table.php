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
        Schema::create('customer_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('customer_inv_num', 50);
            $table->timestamp('customer_inv_date_time');
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            // $table->unsignedBigInteger('user_id');//pharmacist
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->decimal('tax_value',8,2)->nullable()->default(0);
            $table->decimal('tax_after_discount',8,2)->nullable()->default(0);
            $table->decimal('total_before_discount',8,2)->nullable()->default(0);
            $table->decimal('discount_percentage',8,2)->nullable();
            $table->decimal('total_after_discount',8,2)->nullable()->default(0);
            $table->text('notes')->nullable();
            $table->enum('payment_method',['visa','cash'])->nullable();
            $table->enum('payment_type',['cash','by_installments'])->nullable();
            $table->tinyInteger('return_status')->nullable();
            $table->boolean('is_pending')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->decimal('total_commission_rate',10,2)->default(0);
            $table->string('type',100);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_invoices');
    }
};
