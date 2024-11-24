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
        Schema::create('partner_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: 'partner_id' )->unsigned();
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('amount');
            $table->date('date');
            $table->enum('type',['من رأس المال','ارباح','راتب']);
            $table->morphs('sourcable');
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
        Schema::dropIfExists('partner_withdrawals');
    }
};
