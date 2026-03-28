<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table): void {
            $table->id();
            $table->string('type', 16);
            $table->string('full_name', 200)->nullable();
            $table->string('company_name', 200)->nullable();
            $table->string('phone', 32);
            $table->string('phone_secondary', 32)->nullable();
            $table->string('email', 150)->nullable();
            $table->text('notes')->nullable();
            $table->string('source', 64)->nullable();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('phone');
            $table->index('phone_secondary');
            $table->index('full_name');
            $table->index('company_name');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
