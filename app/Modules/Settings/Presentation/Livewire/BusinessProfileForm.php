<?php

namespace App\Modules\Settings\Presentation\Livewire;

use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class BusinessProfileForm extends Component
{
    public ?int $businessProfileId = null;
    public string $full_name_uk = '';
    public string $tax_id = '';
    public string $registration_address_uk = '';
    public string $phone = '';
    public string $email = '';
    public string $website = '';
    public string $signer_name_uk = '';
    public string $signer_title_uk = 'ФОП';

    public function mount(): void
    {
        $profile = BusinessProfile::query()->where('is_active', true)->first() ?? BusinessProfile::query()->first();
        if (! $profile) return;
        $this->businessProfileId = $profile->id;
        foreach (['full_name_uk','tax_id','registration_address_uk','phone','email','website','signer_name_uk','signer_title_uk'] as $field) { $this->{$field} = (string) ($profile->{$field} ?? ''); }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'full_name_uk' => ['required','string','max:255'], 'tax_id' => ['required','string','max:32'], 'registration_address_uk' => ['nullable','string'],
            'phone' => ['nullable','string','max:32'], 'email' => ['nullable','email','max:150'], 'website' => ['nullable','string','max:255'],
            'signer_name_uk' => ['nullable','string','max:255'], 'signer_title_uk' => ['nullable','string','max:255'],
        ]);
        $profile = $this->businessProfileId ? BusinessProfile::query()->findOrFail($this->businessProfileId) : new BusinessProfile();
        $profile->fill($validated + ['legal_type' => 'fop', 'default_locale' => 'uk', 'is_active' => true]);
        $profile->save(); $this->businessProfileId = $profile->id; session()->flash('success', 'Профіль ФОП збережено.');
    }

    public function render(): View { return view('livewire.settings.business-profile-form'); }
}
