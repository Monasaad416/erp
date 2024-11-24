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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_en',255)->nullable();
            $table->string('name_ar',255);
            $table->string('gtin')->comment('الرقم الدولي التجاري للمنتج')->unique()->nullable();
            $table->string('serial_num')->comment('الرقم التسلسلي')->unique()->nullable();
            $table->date('manufactured_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->date('import_date')->nullable();
            $table->float('size')->nullable();
            // $table->string('batch_num')->unique()->comment('رقم التشغيلة');
            $table->float('max_dose')->nullable();
            $table->text('description')->nullable();
            // $table->decimal('purchase_price',12,2);
            $table->decimal('sale_price',12,2);
            $table->decimal('discount_price',12,2)->nullable();
            $table->unsignedBigInteger('category_id' )->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // $table->decimal('initial_balance',12,2);
            $table->unsignedBigInteger('unit_id' )->unsigned();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->boolean('is_active');
            $table->boolean('fraction')->nullable();
            $table->boolean('taxes')->nullable();
            $table->decimal('alert_main_branch',8,2)->nullable();
            $table->decimal('alert_branch',8,2)->nullable();
            // $table->decimal('commission_rate',8,2)->default(50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
