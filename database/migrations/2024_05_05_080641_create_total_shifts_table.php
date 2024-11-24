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
        Schema::create('total_shifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id' )->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('branch_id' )->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('financial_year_id');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('financial_month_id');
            $table->foreign('financial_month_id')->references('id')->on('financial_months')->onDelete('cascade')->onUpdate('cascade');
            $table->float('overtime_mins')->nullable();
            $table->tinyInteger('required_days')->comment('عدد الايام المطلوب حضورها');
            $table->tinyInteger('actual_days')->comment('عدد ايام الحضور الفعلية ');
            $table->decimal('required_hours',8,2)->comment('عدد الساعات المطلوب حضورها');
            $table->decimal('actual_hours',8,2)->comment('عدد ساعات الحضور الفعلية ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('total_shifts');
    }
};
