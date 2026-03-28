<?php

namespace App\Livewire\Clients;

use App\Modules\Clients\Infrastructure\Persistence\Models\Client;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ClientIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $type = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingType(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'type']);
        $this->resetPage();
    }

    public function render(): View
    {
        $clients = Client::query()
            ->when($this->search !== '', function ($query) {
                $query->where(function ($inner) {
                    $inner->where('full_name', 'ilike', '%' . $this->search . '%')
                        ->orWhere('company_name', 'ilike', '%' . $this->search . '%')
                        ->orWhere('phone', 'ilike', '%' . $this->search . '%')
                        ->orWhere('phone_secondary', 'ilike', '%' . $this->search . '%')
                        ->orWhere('email', 'ilike', '%' . $this->search . '%');
                });
            })
            ->when($this->type !== '', fn ($query) => $query->where('type', $this->type))
            ->latest('id')
            ->paginate(20);

        return view('livewire.clients.client-index', [
            'clients' => $clients,
        ]);
    }
}
