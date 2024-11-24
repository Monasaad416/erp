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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('trans_num');
            $table->string('description',1000)->nullable();
            $table->timestamp('trans_date_time');
            $table->unsignedBigInteger('from_store_id' )->unsigned();
            $table->foreign('from_store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->unsignedBigInteger('to_store_id' )->unsigned();
            $table->foreign('to_store_id')->references('id')->on('stores')->onDelete('cascade');
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
        Schema::dropIfExists('inventory_transactions');
    }
};
