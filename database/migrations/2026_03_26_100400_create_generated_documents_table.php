<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('generated_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_order_id')->constrained('service_orders')->cascadeOnDelete();
            $table->foreignId('business_profile_id')->constrained('business_profiles')->restrictOnDelete();
            $table->foreignId('bank_account_id')->nullable()->constrained('bank_accounts')->nullOnDelete();
            $table->string('document_type', 50);
            $table->string('document_number', 100);
            $table->date('document_date');
            $table->string('locale', 10)->default('uk');
            $table->string('status', 30)->default('issued');
            $table->json('snapshot_json');
            $table->string('html_disk', 50)->nullable();
            $table->string('html_path', 500)->nullable();
            $table->string('pdf_disk', 50)->nullable();
            $table->string('pdf_path', 500)->nullable();
            $table->foreignId('issued_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('voided_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('void_reason')->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('voided_at')->nullable();
            $table->timestamps();
            $table->index(['service_order_id', 'document_type']);
            $table->unique(['document_type', 'document_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generated_documents');
    }
};
