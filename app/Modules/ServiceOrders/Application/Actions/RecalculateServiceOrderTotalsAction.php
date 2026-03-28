<?php

namespace App\Modules\ServiceOrders\Application\Actions;

use App\Modules\ServiceOrders\Domain\Enums\PaymentType;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;

class RecalculateServiceOrderTotalsAction
{
    public function execute(ServiceOrder $serviceOrder): ServiceOrder
    {
        $finalPrice = (float) $serviceOrder->items()->sum('total_price');

        $paymentsTotal = (float) $serviceOrder->payments()
            ->where('type', PaymentType::PAYMENT->value)
            ->sum('amount');

        $refundsTotal = (float) $serviceOrder->payments()
            ->where('type', PaymentType::REFUND->value)
            ->sum('amount');

        $paidAmount = $paymentsTotal - $refundsTotal;
        $balanceAmount = max($finalPrice - $paidAmount, 0);

        $serviceOrder->forceFill([
            'final_price' => $finalPrice,
            'paid_amount' => $paidAmount,
            'balance_amount' => $balanceAmount,
        ])->save();

        return $serviceOrder->refresh();
    }
}
