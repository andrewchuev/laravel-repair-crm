<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OrderShow extends Component
{
    public int $serviceOrderId;

    public function getOrderProperty(): ServiceOrder
    {
        return ServiceOrder::query()
            ->with([
                'client',
                'acceptedBy',
                'assignedMaster',
                'items',
                'payments',
                'comments.user',
                'attachments',
                'statusHistory.changedBy',
            ])
            ->findOrFail($this->serviceOrderId);
    }

    public function render(): View
    {
        return view('livewire.service-orders.order-show', [
            'order' => $this->order,
        ]);
    }
}
