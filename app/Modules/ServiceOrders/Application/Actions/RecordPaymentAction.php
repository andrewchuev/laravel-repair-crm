<?php

namespace App\Modules\ServiceOrders\Application\Actions;

use App\Models\User;
use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\Payment;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use Illuminate\Support\Facades\DB;

class RecordPaymentAction
{
    public function __construct(
        private readonly RecalculateServiceOrderTotalsAction $recalculateTotalsAction,
        private readonly LogActivityAction $logActivityAction,
    ) {
    }

    public function execute(ServiceOrder $serviceOrder, array $data, User $actor): Payment
    {
        return DB::transaction(function () use ($serviceOrder, $data, $actor) {
            $payment = Payment::create([
                ...$data,
                'service_order_id' => $serviceOrder->id,
                'created_by_user_id' => $actor->id,
                'paid_at' => $data['paid_at'] ?? now(),
            ]);

            $this->recalculateTotalsAction->execute($serviceOrder);

            $this->logActivityAction->execute(
                entityType: 'service_order',
                entityId: $serviceOrder->id,
                action: 'payment.recorded',
                user: $actor,
                newValues: $payment->toArray(),
            );

            return $payment->refresh();
        });
    }
}
