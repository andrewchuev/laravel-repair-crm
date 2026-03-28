<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_orders', function (Blueprint $table): void {
            $table->id();
            $table->string('order_number', 32)->unique();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('accepted_by_user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('assigned_master_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status', 32);
            $table->string('priority', 16)->default('normal');
            $table->string('category', 32);
            $table->string('item_name', 200);
            $table->string('brand', 120)->nullable();
            $table->string('model', 120)->nullable();
            $table->string('serial_number', 120)->nullable();
            $table->text('reported_problem');
            $table->text('intake_condition')->nullable();
            $table->text('accessories')->nullable();
            $table->jsonb('intake_checklist')->default('{}');
            $table->jsonb('device_snapshot')->default('{}');
            $table->text('diagnostic_summary')->nullable();
            $table->text('work_result')->nullable();
            $table->text('internal_notes')->nullable();
            $table->text('customer_notes')->nullable();
            $table->decimal('estimated_price', 12, 2)->default(0);
            $table->decimal('agreed_price', 12, 2)->default(0);
            $table->decimal('final_price', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('balance_amount', 12, 2)->default(0);
            $table->timestampTz('received_at')->useCurrent();
            $table->timestampTz('promised_at')->nullable();
            $table->timestampTz('approved_at')->nullable();
            $table->timestampTz('ready_at')->nullable();
            $table->timestampTz('delivered_at')->nullable();
            $table->date('warranty_until')->nullable();
            $table->timestampTz('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();

            $table->index('client_id');
            $table->index('status');
            $table->index('assigned_master_id');
            $table->index('received_at');
            $table->index('ready_at');
            $table->index('delivered_at');
            $table->index('serial_number');
            $table->index(['brand', 'model']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
