<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_profile_id')->constrained('business_profiles')->cascadeOnDelete();
            $table->string('title', 150)->nullable();
            $table->string('recipient', 255);
            $table->string('iban', 64);
            $table->string('bank_name', 255);
            $table->string('bank_mfo', 32)->nullable();
            $table->string('bank_edrpou', 32)->nullable();
            $table->string('currency', 10)->default('UAH');
            $table->text('payment_purpose_template')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
