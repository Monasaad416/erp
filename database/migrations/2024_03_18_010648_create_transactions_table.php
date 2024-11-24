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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('serial_num');
            $table->unsignedBigInteger('transaction_type_id' )->unsigned();
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types')->onDelete('cascade');
            $table->nullableMorphs('transactionable');
            $table->enum('state',['تحصيل','صرف']);
            $table->string('inv_num')->nullable();
            $table->string('account_num',100)->nullable();
            $table->boolean('is_account');
            $table->boolean('is_approved')->comment(' اعتماد لقيد اليومية اليدوي فقط -قيود الشاشة تعتمد تلقائيا ');
            $table->unsignedBigInteger('treasury_shift_id' )->unsigned();
            $table->foreign('treasury_shift_id')->references('id')->on('treasury_shifts')->onDelete('cascade');
            $table->decimal('receipt_amount',10,2)->comment('المبلغ المصروف او المحصل بالخزنة');
            $table->decimal('deserved_account_amount',10,2)->comment('المبلغ المستحق للعميل او للحساب او علي الحساب');
            $table->unsignedBigInteger('branch_id' )->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->unsignedBigInteger('treasury_id' );
            $table->foreign('treasury_id')->references('id')->on('treasuries')->onDelete('cascade');
            $table->text('description');
            $table->date('date');
            // $table->enum('payment_method', ['كاش','شبكة'] ) ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fransactions');
    }
};
