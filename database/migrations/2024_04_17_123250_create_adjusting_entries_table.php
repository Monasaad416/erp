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
        Schema::create('adjusting_entries', function (Blueprint $table) {
            $table->id();
            $table->string('debit_account_num',100)->comment('مدين');
            $table->string('credit_account_num',100)->comment('دائن');
            $table->string('debit_account_name_ar', 250);
            $table->string('credit_account_name_ar', 250);
            $table->decimal('debit_amount',12,2);
            $table->decimal('credit_amount',12,2);
            $table->string('description',1000);
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->nullableMorphs('jounralable');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjusting_entries');
    }
};
