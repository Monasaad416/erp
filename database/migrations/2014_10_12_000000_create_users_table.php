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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->bigInteger('account_num')->unique()->comment('حساب الرواتب');
            $table->bigInteger('advance_payment_account_num')->unique()->comment('حساب السلف');
            $table->enum('gender',['male','female']);
            $table->string('password');
            $table->date('joining_date');
            $table->unsignedBigInteger('branch_id' )->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade')->onUpdate('cascade');
            $table->string('roles_name');
            $table->string('fingerprint_code')->nullable();
            $table->string('job_title')->nullable();
            $table->unsignedBigInteger('blood_type_id' )->unsigned()->nullable();
            $table->foreign('blood_type_id')->references('id')->on('blood_types')->onDelete('set null')->onUpdate('set null');
            $table->tinyInteger('no_of_children')->nullable();
            $table->enum('marital_status',['single','married'])->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->date('date_of_birth')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->unsignedBigInteger('nationality_id' )->unsigned()->nullable();
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('set null')->onUpdate('set null');
            $table->boolean('has_driving_license')->nullable();
            $table->string('id_num')->comment('رقم الهوية')->nullable();
            $table->date('id_exp_date')->nullable();
            $table->string('passport_num')->nullable();
            $table->string('passport_exp_date')->nullable();
            $table->integer('age')->nullable();
            $table->date('resignation_date')->nullable();
            $table->enum('work_status',['working','not_working'])->nullable();
            $table->string('image')->nullable();
            $table->integer('vacations_balance')->nullable();
            $table->decimal('salary',12,2)->nullable();
            $table->decimal('overtime_hour_price')->nullable();
            $table->decimal('medical_insurance_deduction')->nullable();
            $table->boolean('has_medical_insurance')->nullable();
            $table->decimal('transfer_allowance')->nullable();
            $table->decimal('housing_allowance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
