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
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entry_num');
            $table->date('date');
            $table->unsignedBigInteger('debit_account_id')->nullable();
            $table->foreign('debit_account_id')->references('id')->on('accounts')->onDelete('set null');
            $table->unsignedBigInteger('credit_account_id')->nullable();
            $table->foreign('credit_account_id')->references('id')->on('accounts')->onDelete('set null');
            $table->string('debit_account_num',100)->comment('مدين');
            $table->string('credit_account_num',100)->comment('دائن');
            $table->decimal('debit_amount',12,2);
            $table->decimal('credit_amount',12,2);
            $table->string('description',1000);
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->nullableMorphs('jounralable');
            // $table->unsignedBigInteger('t_account_id')->nullable();
            // $table->foreign('t_account_id')->references('id')->on('t_accounts')->onDelete('set null');
            $table->unsignedBigInteger('entry_type_id')->nullable();
            $table->foreign('entry_type_id')->references('id')->on('entry_types')->onDelete('set null');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            //             $table->unsignedBigInteger('financial_year_id');
            // $table->foreign('financial_year_id')->references('id')->on('financial_years')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
    }
};
