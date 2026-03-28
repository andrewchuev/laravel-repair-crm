<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class StatusHistoryTimeline extends Component
{
    public int $serviceOrderId;

    #[On('service-order-updated')]
    public function refreshTimeline(): void
    {
        //
    }

    public function render(): View
    {
        $order = ServiceOrder::query()
            ->with(['statusHistory.changedBy'])
            ->findOrFail($this->serviceOrderId);

        return view('livewire.service-orders.status-history-timeline', [
            'history' => $order->statusHistory()->with('changedBy')->latest('created_at')->get(),
        ]);
    }
}
