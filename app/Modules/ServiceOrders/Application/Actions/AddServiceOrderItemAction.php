<?php

namespace App\Modules\ServiceOrders\Application\Actions;

use App\Models\User;
use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderItem;
use Illuminate\Support\Facades\DB;

class AddServiceOrderItemAction
{
    public function __construct(
        private readonly RecalculateServiceOrderTotalsAction $recalculateTotalsAction,
        private readonly LogActivityAction $logActivityAction,
    ) {
    }

    public function execute(ServiceOrder $serviceOrder, array $data, User $actor): ServiceOrderItem
    {
        return DB::transaction(function () use ($serviceOrder, $data, $actor) {
            $quantity = (float) $data['quantity'];
            $unitPrice = (float) $data['unit_price'];

            $item = ServiceOrderItem::create([
                ...$data,
                'service_order_id' => $serviceOrder->id,
                'total_price' => round($quantity * $unitPrice, 2),
                'created_by_user_id' => $actor->id,
                'position' => $data['position'] ?? (($serviceOrder->items()->max('position') ?? 0) + 1),
            ]);

            $this->recalculateTotalsAction->execute($serviceOrder);

            $this->logActivityAction->execute(
                entityType: 'service_order',
                entityId: $serviceOrder->id,
                action: 'service_order.item_added',
                user: $actor,
                newValues: $item->toArray(),
            );

            return $item->refresh();
        });
    }
}
