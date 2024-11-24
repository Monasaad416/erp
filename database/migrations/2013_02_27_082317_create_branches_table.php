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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('branch_num')->unsigned();
            $table->string('name_ar',100);
            $table->string('name_en',100)->nullable();
            $table->string('email',100)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('gln')->unique()->comment('رقم الموقع العالمي')->nullable();
            $table->string('phone')->nullable();
            $table->string('street_name_en')->nullable();
            $table->string('street_name_ar');
            $table->string('city_ar',100);
            $table->string('city_en',100)->nullable();
            $table->string('region_ar',100);
            $table->string('region_en',100)->nullable();
            $table->string('sub_number',10);
            $table->string('building_number',10);
            $table->string('plot_identification',10)->comment('sub_number')->nullable();
            $table->string('postal_code',10);
            $table->boolean('is_active');
            $table->unsignedBigInteger('cost_center_id')->nullable();
            $table->foreign('cost_center_id')->references('id')->on('cost_centers')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
