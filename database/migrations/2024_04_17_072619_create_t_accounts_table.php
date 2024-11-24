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
        Schema::create('t_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('serial_num');
            // $table->date('date');
            $table->bigInteger('account_num');
            $table->string('journal_type')->comment('نوع القيد مدين-دائن');
            $table->decimal('amount',12,2)->nullable();
            $table->string('description',1000);
            $table->unsignedBigInteger('journal_entry_id')->nullable();
            $table->foreign('journal_entry_id')->references('id')->on('journal_entries')->onDelete('set null');
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('set null');
            $table->unsignedBigInteger('ledger_id')->nullable();
            $table->foreign('ledger_id')->references('id')->on('ledgers')->onDelete('set null');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('t_accounts');
    }
};
