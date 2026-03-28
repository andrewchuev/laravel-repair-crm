<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_order_attachments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('service_order_id')->constrained('service_orders')->cascadeOnDelete();
            $table->foreignId('uploaded_by_user_id')->constrained('users')->restrictOnDelete();
            $table->string('type', 32);
            $table->string('original_name', 255);
            $table->string('stored_name', 255);
            $table->string('disk', 64);
            $table->string('path', 500);
            $table->string('mime_type', 128);
            $table->string('extension', 16)->nullable();
            $table->unsignedBigInteger('size_bytes')->default(0);
            $table->string('checksum', 128)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestampTz('taken_at')->nullable();
            $table->jsonb('meta')->default('{}');
            $table->timestamps();

            $table->index('service_order_id');
            $table->index('type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_order_attachments');
    }
};
