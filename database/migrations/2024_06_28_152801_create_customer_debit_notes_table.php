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
        Schema::create('customer_debit_notes', function (Blueprint $table) {
            $table->id();
            $table->string('serial_num')->comment('الرقم التسلسلي');
            $table->unsignedBigInteger('customer_invoice_id')->nullable();
            $table->foreign('customer_invoice_id')->references('id')->on('customer_invoices')->onDelete('set null');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->decimal('total_without_tax',8,2)->default(0);
            $table->decimal('tax',8,2)->default(0);
            $table->decimal('total_with_tax',8,2)->default(0);
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->string('type',100);
            $table->enum('payment_method',['cash','visa']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_debit_notes');
    }
};
