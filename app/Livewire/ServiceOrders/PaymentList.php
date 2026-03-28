<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class PaymentList extends Component
{
    public int $serviceOrderId;

    #[On('service-order-updated')]
    public function refreshPayments(): void
    {
        //
    }

    public function render(): View
    {
        $order = ServiceOrder::query()
            ->with('payments')
            ->findOrFail($this->serviceOrderId);

        return view('livewire.service-orders.payment-list', [
            'order' => $order,
            'payments' => $order->payments()->latest('paid_at')->get(),
        ]);
    }
}
