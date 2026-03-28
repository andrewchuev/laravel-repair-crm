<?php

namespace App\Modules\Settings\Presentation\Livewire;

use App\Modules\Settings\Infrastructure\Persistence\Models\BankAccount;
use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class BankAccountForm extends Component
{
    public ?int $bankAccountId = null;
    public string $name_uk = 'Основний рахунок';
    public string $recipient_name_uk = '';
    public string $iban = '';
    public string $bank_name_uk = '';
    public string $bank_mfo = '';
    public string $bank_edrpou = '';
    public string $payment_purpose_template_uk = '';

    public function mount(): void
    {
        $account = BankAccount::query()->where('is_default', true)->first() ?? BankAccount::query()->first();
        if (! $account) return;
        $this->bankAccountId = $account->id;
        foreach (['name_uk','recipient_name_uk','iban','bank_name_uk','bank_mfo','bank_edrpou','payment_purpose_template_uk'] as $field) { $this->{$field} = (string) ($account->{$field} ?? ''); }
    }

    public function save(): void
    {
        $profile = BusinessProfile::query()->where('is_active', true)->first() ?? BusinessProfile::query()->first();
        abort_unless($profile, 422, 'Спочатку заповніть профіль ФОП.');
        $validated = $this->validate([
            'name_uk' => ['nullable','string','max:255'], 'recipient_name_uk' => ['required','string','max:255'], 'iban' => ['required','string','max:64'],
            'bank_name_uk' => ['required','string','max:255'], 'bank_mfo' => ['nullable','string','max:32'], 'bank_edrpou' => ['nullable','string','max:32'],
            'payment_purpose_template_uk' => ['nullable','string'],
        ]);
        BankAccount::query()->where('business_profile_id', $profile->id)->update(['is_default' => false]);
        $account = $this->bankAccountId ? BankAccount::query()->findOrFail($this->bankAccountId) : new BankAccount();
        $account->fill($validated + ['business_profile_id' => $profile->id, 'is_default' => true]);
        $account->save(); $this->bankAccountId = $account->id; session()->flash('success', 'Банківські реквізити збережено.');
    }

    public function render(): View { return view('livewire.settings.bank-account-form'); }
}
