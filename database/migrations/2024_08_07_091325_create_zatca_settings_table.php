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
        Schema::create('zatca_settings', function (Blueprint $table) {
            $table->id();
            $table->string('tax_num',50)->nullable();
            $table->string('commercial_register',50)->nullable();
            $table->string('name')->nullable();
            $table->string('otp')->nullable();
            $table->unsignedBigInteger('branch_id' )->unsigned()->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->boolean('is_production')->default(false);
            $table->text('complianceCertificate')->nullable();
            $table->text('complianceSecret')->nullable();
            $table->text('complianceRequestID')->nullable();
            $table->text('productionCertificate')->nullable();
            $table->text('productionCertificateSecret')->nullable();
            $table->text('productionCertificateRequestID')->nullable();
            $table->text('privateKey')->nullable();
            $table->text('publicKey')->nullable();
            $table->text('csrKey')->nullable();
            $table->text('configData')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zatca_settings');
    }
};
