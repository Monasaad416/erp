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
        Schema::create('treasury_shifts', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_id' )->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('start_shift_cash_balance',10,2);
            $table->decimal('end_shift_cash_balance',10,2);
            $table->decimal('end_shift_bank_balance',10,2);
            // $table->decimal('amount_delivered',10,2)->comment('المبلغ الفعلي للكاش المسلم اخر الوردية')->default(0);
            $table->timestamp('start_shift_date_time')->nullable();
            $table->timestamp('end_shift_date_time')->nullable();
            $table->boolean('is_delivered')->comment('تم تسليم الوردية');
            $table->boolean('is_approved')->comment('تم استلام الوردية');
            $table->unsignedBigInteger('delivered_to_user_id' )->unsigned()->comment('كود الموظف مستلم الوردية');
            $table->foreign('delivered_to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('delivered_shift_id' )->unsigned();
            $table->foreign('delivered_shift_id')->references('id')->on('shift_types')->onDelete('cascade');
            $table->unsignedBigInteger('delivered_to_shift_id' )->unsigned();
            $table->foreign('delivered_to_shift_id')->references('id')->on('shift_types')->onDelete('cascade');
            $table->tinyInteger('amount_status')->nullable();
            $table->decimal('amount_status_value')->comment('قيمة العجز او الزيادة او الاتزان')->nullable();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('treasury_id')->unsigned();
            $table->foreign('treasury_id')->references('id')->on('treasuries')->onDelete('cascade');
            $table->unsignedBigInteger('bank_id')->unsigned()->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');
            // $table->unsignedBigInteger('transaction_id' )->unsigned();
            // $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasury_shifts');
    }
};
