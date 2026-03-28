<?php

namespace App\Modules\ServiceOrders\Application\Actions;

use App\Models\User;
use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderStatus;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderStatusHistory;
use DomainException;
use Illuminate\Support\Facades\DB;

class ChangeServiceOrderStatusAction
{
    public function __construct(
        private readonly LogActivityAction $logActivityAction,
    ) {
    }

    public function execute(ServiceOrder $serviceOrder, ServiceOrderStatus $newStatus, User $actor, ?string $comment = null): ServiceOrder
    {
        if (! $serviceOrder->canTransitionTo($newStatus)) {
            throw new DomainException("Invalid status transition from {$serviceOrder->status->value} to {$newStatus->value}.");
        }

        return DB::transaction(function () use ($serviceOrder, $newStatus, $actor, $comment) {
            $oldStatus = $serviceOrder->status;

            $serviceOrder->status = $newStatus;

            if ($newStatus === ServiceOrderStatus::READY) {
                $serviceOrder->ready_at = now();
            }

            if ($newStatus === ServiceOrderStatus::DELIVERED) {
                $serviceOrder->delivered_at = now();
            }

            if ($newStatus === ServiceOrderStatus::CANCELLED) {
                $serviceOrder->cancelled_at = now();
                $serviceOrder->cancellation_reason = $comment;
            }

            $serviceOrder->save();

            ServiceOrderStatusHistory::create([
                'service_order_id' => $serviceOrder->id,
                'old_status' => $oldStatus->value,
                'new_status' => $newStatus->value,
                'comment' => $comment,
                'changed_by_user_id' => $actor->id,
                'created_at' => now(),
            ]);

            $this->logActivityAction->execute(
                entityType: 'service_order',
                entityId: $serviceOrder->id,
                action: 'service_order.status_changed',
                user: $actor,
                oldValues: ['status' => $oldStatus->value],
                newValues: ['status' => $newStatus->value],
                context: ['comment' => $comment],
            );

            return $serviceOrder->refresh();
        });
    }
}
