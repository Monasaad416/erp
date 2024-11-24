<?php

use App\Models\Unit;
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
        Schema::create('inventory_counts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inv_count_num');
            $table->string('name_en',255)->nullable();
            $table->string('name_ar',255);
            $table->string('product_code',255);
            $table->string('serial_num')->comment('الرقم التسلسلي')->unique()->nullable();
            // $table->unsignedBigInteger('category_id' )->unsigned();
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // $table->unsignedBigInteger('supplier_id' )->unsigned();
            // $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->string('unit' );
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->decimal('system_qty',12,2);
            // $table->decimal('in_qty',12,2);
            // $table->decimal('out_qty',12,2);
            $table->decimal('actual_qty',12,2);
            // $table->decimal('current_price',12,2)->comment('current_qty *Unit');
            $table->decimal('latest_purchase_price',12,2)->nullable();

            $table->date('from_date');
            $table->date('to_date');
            $table->boolean('is_settled')->nullable();
            $table->enum('state',['فائض','متزن','عجز']);
            $table->decimal('state_qty')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_counts');
    }
};
