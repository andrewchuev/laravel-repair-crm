<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class OrderIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $category = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'category' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'status', 'category']);
        $this->resetPage();
    }

    public function render(): View
    {
        $orders = ServiceOrder::query()
            ->with(['client', 'assignedMaster'])
            ->when($this->search !== '', function ($query) {
                $query->where(function ($inner) {
                    $inner->where('order_number', 'ilike', '%' . $this->search . '%')
                        ->orWhere('item_name', 'ilike', '%' . $this->search . '%')
                        ->orWhere('serial_number', 'ilike', '%' . $this->search . '%')
                        ->orWhereHas('client', function ($clientQuery) {
                            $clientQuery->where('full_name', 'ilike', '%' . $this->search . '%')
                                ->orWhere('company_name', 'ilike', '%' . $this->search . '%')
                                ->orWhere('phone', 'ilike', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->status !== '', fn ($query) => $query->where('status', $this->status))
            ->when($this->category !== '', fn ($query) => $query->where('category', $this->category))
            ->latest('received_at')
            ->paginate(20);

        return view('livewire.service-orders.order-index', [
            'orders' => $orders,
            'statuses' => ['new', 'diagnostics', 'awaiting_approval', 'approved', 'in_progress', 'waiting_parts', 'ready', 'delivered', 'cancelled'],
            'categories' => ['computer', 'laptop', 'printer', 'mfp', 'cartridge', 'monitor', 'network', 'other'],
        ]);
    }
}
