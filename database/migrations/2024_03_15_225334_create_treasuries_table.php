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
        Schema::create('treasuries', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar',100);
            $table->string('name_en',100)->nullable();
            $table->decimal('current_balance',12,2);
            $table->bigInteger('last_exchange_receipt')->nullable();
            $table->bigInteger('last_collection_receipt')->nullable();
            $table->boolean('is_parent')->nullable();
            $table->boolean('is_active');
            $table->bigInteger('account_num');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null')->onUpdate('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasuries');
    }
};
