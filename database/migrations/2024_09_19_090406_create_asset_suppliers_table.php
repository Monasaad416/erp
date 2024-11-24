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
        Schema::create('asset_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('gln')->unique()->comment('رقم الموقع العالمي')->nullable();
            $table->string('tax_num')->unique()->comment('الرقم الضريبي')->nullable();
            $table->unsignedBigInteger('branch_id' )->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('account_num');
            $table->decimal('start_balance',12,2)->default(0);
            $table->decimal('current_balance',12,2)->default(0);
            $table->enum('balance_state',['متزن','دائن','مدين']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_suppliers');
    }
};
