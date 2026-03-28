<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CommentList extends Component
{
    public int $serviceOrderId;

    #[On('service-order-updated')]
    public function refreshComments(): void
    {
        //
    }

    public function render(): View
    {
        $order = ServiceOrder::query()
            ->with(['comments.user'])
            ->findOrFail($this->serviceOrderId);

        return view('livewire.service-orders.comment-list', [
            'comments' => $order->comments()->with('user')->latest('id')->get(),
        ]);
    }
}
