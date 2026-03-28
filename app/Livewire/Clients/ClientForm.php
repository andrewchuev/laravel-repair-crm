<?php

namespace App\Livewire\Clients;

use App\Modules\Clients\Infrastructure\Persistence\Models\Client;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ClientForm extends Component
{
    public ?int $clientId = null;

    public string $type = 'person';
    public string $full_name = '';
    public string $company_name = '';
    public string $phone = '';
    public string $phone_secondary = '';
    public string $email = '';
    public string $notes = '';
    public string $source = '';

    public function mount(?int $clientId = null): void
    {
        $this->clientId = $clientId;

        if (! $clientId) {
            return;
        }

        $client = Client::query()->findOrFail($clientId);

        $this->type = (string) ($client->type->value ?? $client->type);
        $this->full_name = (string) ($client->full_name ?? '');
        $this->company_name = (string) ($client->company_name ?? '');
        $this->phone = (string) ($client->phone ?? '');
        $this->phone_secondary = (string) ($client->phone_secondary ?? '');
        $this->email = (string) ($client->email ?? '');
        $this->notes = (string) ($client->notes ?? '');
        $this->source = (string) ($client->source ?? '');
    }

    protected function rules(): array
    {
        return [
            'type' => ['required', Rule::in(['person', 'company'])],
            'full_name' => ['nullable', 'string', 'max:200', Rule::requiredIf($this->type === 'person')],
            'company_name' => ['nullable', 'string', 'max:200', Rule::requiredIf($this->type === 'company')],
            'phone' => ['required', 'string', 'max:32'],
            'phone_secondary' => ['nullable', 'string', 'max:32'],
            'email' => ['nullable', 'email', 'max:150'],
            'notes' => ['nullable', 'string'],
            'source' => ['nullable', 'string', 'max:64'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $client = $this->clientId
            ? Client::query()->findOrFail($this->clientId)
            : new Client();

        $client->fill($validated);

        if (! $client->exists) {
            $client->created_by_user_id = auth()->id();
        }

        $client->save();

        session()->flash('success', $this->clientId ? 'Client updated successfully.' : 'Client created successfully.');

        return redirect()->route('app.clients.edit', $client->id);
    }

    public function render(): View
    {
        return view('livewire.clients.client-form');
    }
}
