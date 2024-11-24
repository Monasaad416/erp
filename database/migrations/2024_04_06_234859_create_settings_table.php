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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('vat')->nullable();
            $table->decimal('percentage_for_pos')->nullable();
            $table->decimal('min_exchange_pos')->nullable();
            $table->decimal('max_exchange_pos')->nullable();
            $table->decimal('num_of_points')->nullable();
            $table->integer('expiry_days')->nullable();
            $table->decimal('point_price')->nullable();
            // $table->string('tax_num',50)->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
