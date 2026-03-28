<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('document_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_profile_id')->constrained('business_profiles')->cascadeOnDelete();
            $table->string('document_locale', 10)->default('uk');
            $table->string('invoice_prefix', 20)->default('РХ');
            $table->string('intake_act_prefix', 20)->default('АР');
            $table->string('completion_act_prefix', 20)->default('АВР');
            $table->string('warranty_prefix', 20)->default('ГТ');
            $table->string('number_format', 50)->default('{prefix}-{year}-{seq}');
            $table->string('default_city', 100)->nullable();
            $table->text('invoice_footer')->nullable();
            $table->text('intake_terms')->nullable();
            $table->text('completion_terms')->nullable();
            $table->text('warranty_terms')->nullable();
            $table->text('storage_terms')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_settings');
    }
};
