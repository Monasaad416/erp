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
        Schema::create('zatca_documents', function (Blueprint $table) {
            $table->id();
            $table->string('icv', 191);
            $table->string('uuid', 191)->unique();
            $table->string('hash', 191)->nullable();
            $table->longText('xml')->nullable();
            $table->boolean('sent_to_zatca')->default(false)->nullable();
            $table->string('sent_to_zatca_status', 191)->nullable();
            $table->dateTime('signing_time')->nullable()->nullable();
            $table->longText('response')->nullable()->nullable();
            $table->string('invoice_id', 191);
            $table->string('company_id', 191)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zatca_documents');
    }
};
