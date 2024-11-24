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
        Schema::create('income_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('set null');
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->bigInteger('account_num');
            $table->decimal('balance',12,2);
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->enum('type',['مصروف','ايراد']);
            // $table->unsignedBigInteger('financial_year_id');
            // $table->foreign('financial_year_id')->references('id')->on('financial_years')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_lists');
    }
};
