<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_order_comments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('service_order_id')->constrained('service_orders')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('visibility', 16);
            $table->text('body');
            $table->timestamps();

            $table->index('service_order_id');
            $table->index('visibility');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_order_comments');
    }
};
