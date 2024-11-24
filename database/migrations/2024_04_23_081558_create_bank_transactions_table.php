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
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_transaction_type_id' )->unsigned();
            $table->foreign('bank_transaction_type_id')->references('id')->on('bank_transaction_types')->onDelete('cascade');
            $table->nullableMorphs('transactionable');
            $table->enum('state',['صرف-لخدمات','تحويل-ايرادات-مبيعات','تحصيل-من-مورد','صرف-لمورد']);
            $table->string('inv_num')->nullable();
            $table->string('check_num')->nullable();
            $table->bigInteger('account_num')->nullable();
            $table->boolean('is_account');
            $table->boolean('is_approved')->comment(' اعتماد لقيد اليومية اليدوي فقط -قيود الشاشة تعتمد تلقائيا ');
            $table->boolean('is_confirmed')->comment('تمت عملية الايداع او الصرف');
            $table->decimal('amount',10,2)->comment('المبلغ المصروف او المحصل أو المحول');
            $table->decimal('deserved_account_amount',10,2)->nullable()->comment('المبلغ المستحق للعميل او للحساب او علي الحساب');
            $table->unsignedBigInteger('branch_id' )->unsigned()->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->unsignedBigInteger('bank_id' )->unsigned();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
            $table->text('description');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_transactions');
    }
};
