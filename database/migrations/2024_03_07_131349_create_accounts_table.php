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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('account_num',100);
            $table->string('parent_account_num',100)->nullable();
            $table->decimal('start_balance',12,2)->default(0);
            $table->decimal('current_balance',12,2)->default(0);
            $table->string('notes')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->enum('nature',['مدين','دائن','دائن-مدين'])->nullable();
            $table->enum('list',['مركز-مالي','دخل']);
            // $table->morphs('accountable');
            $table->unsignedBigInteger('branch_id' )->unsigned()->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->unsignedBigInteger('parent_id' )->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('accounts')->onDelete('set null');
            $table->unsignedBigInteger('account_type_id' )->unsigned()->nullable();
            $table->foreign('account_type_id')->references('id')->on('account_types')->onDelete('set null');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_parent')->default(0);
            $table->tinyInteger('level');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
