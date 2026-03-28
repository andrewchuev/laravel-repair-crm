<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderComment;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CommentForm extends Component
{
    public int $serviceOrderId;

    public string $visibility = 'internal';
    public string $body = '';

    public function save(): void
    {
        $validated = $this->validate([
            'visibility' => ['required', 'in:internal,public'],
            'body' => ['required', 'string', 'max:5000'],
        ]);

        ServiceOrderComment::query()->create([
            'service_order_id' => $this->serviceOrderId,
            'user_id' => auth()->id(),
            'visibility' => $validated['visibility'],
            'body' => $validated['body'],
        ]);

        $this->reset('body');
        $this->visibility = 'internal';

        $this->dispatch('service-order-updated');
    }

    public function render(): View
    {
        return view('livewire.service-orders.comment-form');
    }
}
