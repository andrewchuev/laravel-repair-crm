<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\Payment;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PaymentForm extends Component
{
    public int $serviceOrderId;

    public string $type = 'payment';
    public string $method = 'cash';
    public string $amount = '0';
    public string $comment = '';

    public function save(): void
    {
        $validated = $this->validate([
            'type' => ['required', 'in:payment,refund'],
            'method' => ['required', 'in:cash,card,bank_transfer,other'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $order = $this->order();

        DB::transaction(function () use ($order, $validated): void {
            Payment::query()->create([
                'service_order_id' => $order->id,
                'type' => $validated['type'],
                'method' => $validated['method'],
                'amount' => (float) $validated['amount'],
                'paid_at' => now(),
                'comment' => $validated['comment'] ?: null,
                'created_by_user_id' => auth()->id(),
            ]);

            $this->recalculateTotals($order->fresh());
        });

        $this->resetForm();
        $this->dispatch('service-order-updated');
    }

    public function render(): View
    {
        return view('livewire.service-orders.payment-form');
    }

    private function order(): ServiceOrder
    {
        return ServiceOrder::query()->findOrFail($this->serviceOrderId);
    }

    private function recalculateTotals(ServiceOrder $order): void
    {
        $payments = $order->payments()->get();
        $final = (float) $order->final_price;
        $paid = 0.0;

        foreach ($payments as $payment) {
            $type = (string) ($payment->type->value ?? $payment->type);
            $amount = (float) $payment->amount;

            $paid += $type === 'refund' ? -$amount : $amount;
        }

        $order->paid_amount = max($paid, 0);
        $order->balance_amount = max($final - $order->paid_amount, 0);
        $order->save();
    }

    private function resetForm(): void
    {
        $this->type = 'payment';
        $this->method = 'cash';
        $this->amount = '0';
        $this->comment = '';
    }
}
