<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderItem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class OrderItemList extends Component
{
    public int $serviceOrderId;

    #[On('service-order-updated')]
    public function refreshItems(): void
    {
        //
    }

    public function deleteItem(int $itemId): void
    {
        $order = $this->order();

        DB::transaction(function () use ($order, $itemId): void {
            ServiceOrderItem::query()
                ->where('service_order_id', $order->id)
                ->whereKey($itemId)
                ->delete();

            $this->recalculateTotals($order->fresh());
        });

        $this->dispatch('service-order-updated');
    }

    public function render(): View
    {
        $order = $this->order()->load('items');

        return view('livewire.service-orders.order-item-list', [
            'order' => $order,
            'items' => $order->items()->orderBy('position')->orderBy('id')->get(),
        ]);
    }

    private function order(): ServiceOrder
    {
        return ServiceOrder::query()->findOrFail($this->serviceOrderId);
    }

    private function recalculateTotals(ServiceOrder $order): void
    {
        $final = (float) $order->items()->sum('total_price');
        $paid = (float) $order->paid_amount;

        $order->final_price = $final;
        $order->balance_amount = max($final - $paid, 0);
        $order->save();
    }
}
