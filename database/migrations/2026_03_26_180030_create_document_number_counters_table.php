<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('document_number_counters', function (Blueprint $table): void {
            $table->id(); $table->string('document_type', 50); $table->unsignedSmallInteger('year'); $table->string('prefix', 20); $table->unsignedInteger('last_number')->default(0); $table->timestamps();
            $table->unique(['document_type', 'year']);
        });
    }
    public function down(): void { Schema::dropIfExists('document_number_counters'); }
};