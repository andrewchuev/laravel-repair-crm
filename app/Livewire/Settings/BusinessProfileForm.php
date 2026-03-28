<?php

namespace App\Livewire\Settings;

use App\Modules\Settings\Application\Actions\SaveBusinessProfileAction;
use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class BusinessProfileForm extends Component
{
    public string $legal_name = '';
    public string $short_name = '';
    public string $tax_id = '';
    public string $registration_number = '';
    public string $vat_number = '';
    public string $default_locale = 'uk';
    public string $phone = '';
    public string $email = '';
    public string $website = '';
    public string $registration_address = '';
    public string $actual_address = '';
    public string $city = '';
    public string $postal_code = '';
    public string $signer_name = '';
    public string $signer_title = '';

    public function mount(): void
    {
        $profile = BusinessProfile::query()->first();

        if (! $profile) {
            return;
        }

        foreach ($this->fieldNames() as $field) {
            $this->{$field} = (string) ($profile->{$field} ?? '');
        }
    }

    public function save(SaveBusinessProfileAction $action): void
    {
        $validated = $this->validate([
            'legal_name' => ['required', 'string', 'max:255'],
            'short_name' => ['nullable', 'string', 'max:255'],
            'tax_id' => ['required', 'string', 'max:32'],
            'registration_number' => ['nullable', 'string', 'max:64'],
            'vat_number' => ['nullable', 'string', 'max:32'],
            'default_locale' => ['required', 'string', 'max:10'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'website' => ['nullable', 'string', 'max:150'],
            'registration_address' => ['nullable', 'string', 'max:500'],
            'actual_address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'signer_name' => ['nullable', 'string', 'max:255'],
            'signer_title' => ['nullable', 'string', 'max:255'],
        ]);

        $action->execute($validated);

        session()->flash('success', 'Business profile saved successfully.');
        $this->dispatch('toast', type: 'success', message: 'Business profile saved successfully.');
    }

    public function render(): View
    {
        return view('livewire.settings.business-profile-form');
    }

    private function fieldNames(): array
    {
        return ['legal_name','short_name','tax_id','registration_number','vat_number','default_locale','phone','email','website','registration_address','actual_address','city','postal_code','signer_name','signer_title'];
    }
}
