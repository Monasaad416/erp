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
        Schema::create('adjusted_taxes', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',12,2);
            $table->date('start_date');
            $table->date('end_date');
            $table->date('adjust_date')->comment('تاريخ التسوية مع الهيأة')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->boolean('is_adjusted')->nullable();
            $table->enum('payment_method',['treasury','bank'])->nullable();
            $table->unsignedBigInteger('bank_id')->unsigned()->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjusted_taxes');
    }
};
