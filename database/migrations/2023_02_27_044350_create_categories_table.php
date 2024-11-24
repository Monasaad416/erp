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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_en',255)->nullable();
            $table->string('name_ar',255);
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->unsignedBigInteger('parent_id' )->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
