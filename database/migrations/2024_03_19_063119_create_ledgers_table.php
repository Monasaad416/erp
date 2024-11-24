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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->decimal('debit_amount',12,2)->nullable();
            $table->decimal('credit_amount',12,2)->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('set null');
            $table->bigInteger('account_num');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->boolean('is_checked')->nullable();
            $table->unsignedBigInteger('journal_entry_id')->nullable();
            $table->foreign('journal_entry_id')->references('id')->on('journal_entries')->onDelete('set null')->onUpdate('set null');
             $table->unsignedBigInteger('closing_entry_id')->nullable();
            $table->foreign('closing_entry_id')->references('id')->on('closing_entries')->onDelete('set null')->onUpdate('set null');
            $table->enum('type',['journal_entry','closing_entry']);
            $table->timestamp('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledgers');
    }
};
