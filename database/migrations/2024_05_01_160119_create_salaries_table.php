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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id' )->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('branch_id' )->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('salary',8,2);
            $table->float('overtime_mins')->nullable();
            $table->decimal('total_overtime')->nullable();
            $table->float('delay_mins')->nullable();
            $table->decimal('total_delay')->nullable();
            $table->enum('receiving_type',['cash','visa'])->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null')->onUpdate('set null');
            // $table->string('check_num')->nullable();
            $table->decimal('medical_insurance_deduction',8,2)->nullable();
            $table->decimal('transfer_allowance',8,2)->nullable();
            $table->decimal('housing_allowance',8,2)->nullable();
            $table->decimal('total_commission_rate',10,2)->nullable();
            $table->unsignedBigInteger('financial_year_id');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('financial_month_id');
            $table->foreign('financial_month_id')->references('id')->on('financial_months')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('deductions',8,2)->nullable();
            $table->decimal('rewards',8,2)->nullable();
            $table->decimal('advance_payment_deduction',8,2)->nullable()->commnt('خصم السلف');
            $table->boolean('received');
            $table->boolean('deserved');
            $table->tinyInteger('required_days')->comment('عدد الايام المطلوب حضورها');
            $table->tinyInteger('actual_days')->comment('عدد ايام الحضور الفعلية ');
            $table->decimal('required_hours',8,2)->comment('عدد الساعات المطلوب حضورها')->nullable();
            $table->decimal('actual_hours',8,2)->comment('عدد ساعات الحضور الفعلية ')->nullable();
            $table->date('from_date');
            $table->date('to_date');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
