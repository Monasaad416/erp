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
        Schema::create('month_shifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id' )->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('branch_id' )->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('financial_year_id');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('financial_month_id');
            $table->foreign('financial_month_id')->references('id')->on('financial_months')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('day_num');
            $table->unsignedBigInteger('shift_type_id')->nullable();
            $table->foreign('shift_type_id')->references('id')->on('shift_types')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('shift_hours',8,2)->nullable();
            $table->time('shift_start')->nullable();
            $table->time('shift_end')->nullable();
            $table->time('user_attend_at')->nullable();
            $table->time('user_leave_at')->nullable();
            $table->boolean('attended')->nullable();
            $table->float('overtime_mins')->nullable();
            $table->float('delay_mins')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('month_shifts');
    }
};
