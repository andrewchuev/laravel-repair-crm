<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('document_preferences', function (Blueprint $table): void {
            $table->id(); $table->foreignId('business_profile_id')->constrained('business_profiles')->cascadeOnDelete();
            $table->string('invoice_prefix', 20)->default('INV'); $table->string('intake_act_prefix', 20)->default('RIN'); $table->string('completion_act_prefix', 20)->default('ACT');
            $table->string('default_document_locale', 8)->default('uk'); $table->text('repair_terms_uk')->nullable(); $table->text('storage_terms_uk')->nullable();
            $table->text('diagnostic_terms_uk')->nullable(); $table->text('warranty_terms_uk')->nullable(); $table->text('invoice_footer_uk')->nullable();
            $table->text('completion_act_footer_uk')->nullable(); $table->timestamps(); $table->unique('business_profile_id');
        });
    }
    public function down(): void { Schema::dropIfExists('document_preferences'); }
};