<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('business_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('legal_name', 255);
            $table->string('short_name', 255)->nullable();
            $table->string('tax_id', 32);
            $table->string('registration_number', 64)->nullable();
            $table->string('vat_number', 32)->nullable();
            $table->string('default_locale', 10)->default('uk');
            $table->string('phone', 50)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('website', 150)->nullable();
            $table->string('registration_address', 500)->nullable();
            $table->string('actual_address', 500)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('signer_name', 255)->nullable();
            $table->string('signer_title', 255)->nullable();
            $table->string('logo_path', 500)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_profiles');
    }
};
