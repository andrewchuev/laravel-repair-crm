<?php

namespace App\Modules\ServiceOrders\Application\Actions;

use App\Models\User;
use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderPriority;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderStatus;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderStatusHistory;
use Illuminate\Support\Facades\DB;

class CreateServiceOrderAction
{
    public function __construct(
        private readonly LogActivityAction $logActivityAction,
    ) {
    }

    public function execute(array $data, User $actor): ServiceOrder
    {
        return DB::transaction(function () use ($data, $actor) {
            $serviceOrder = ServiceOrder::create([
                ...$data,
                'order_number' => $data['order_number'] ?? $this->generateOrderNumber(),
                'accepted_by_user_id' => $actor->id,
                'status' => $data['status'] ?? ServiceOrderStatus::NEW->value,
                'priority' => $data['priority'] ?? ServiceOrderPriority::NORMAL->value,
                'received_at' => $data['received_at'] ?? now(),
                'intake_checklist' => $data['intake_checklist'] ?? [],
                'device_snapshot' => $data['device_snapshot'] ?? [],
            ]);

            ServiceOrderStatusHistory::create([
                'service_order_id' => $serviceOrder->id,
                'old_status' => null,
                'new_status' => $serviceOrder->status->value,
                'comment' => __('service_orders.messages.initial_status'),
                'changed_by_user_id' => $actor->id,
                'created_at' => now(),
            ]);

            $this->logActivityAction->execute(
                entityType: 'service_order',
                entityId: $serviceOrder->id,
                action: 'service_order.created',
                user: $actor,
                newValues: $serviceOrder->toArray(),
            );

            return $serviceOrder->refresh();
        });
    }

    private function generateOrderNumber(): string
    {
        $prefix = 'RP-'.now()->format('Y');
        $lastId = ServiceOrder::query()->max('id') ?? 0;
        $sequence = str_pad((string) ($lastId + 1), 6, '0', STR_PAD_LEFT);

        return "{$prefix}-{$sequence}";
    }
}
