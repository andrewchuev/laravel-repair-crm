<?php

namespace App\Livewire\Settings;

use App\Modules\Settings\Application\Actions\SaveBankAccountAction;
use App\Modules\Settings\Infrastructure\Persistence\Models\BankAccount;
use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class BankAccountForm extends Component
{
    public string $title = '';
    public string $recipient = '';
    public string $iban = '';
    public string $bank_name = '';
    public string $bank_mfo = '';
    public string $bank_edrpou = '';
    public string $currency = 'UAH';
    public string $payment_purpose_template = '';
    public bool $is_default = true;
    public bool $is_active = true;

    public function mount(): void
    {
        $account = BankAccount::query()->orderByDesc('is_default')->first();

        if (! $account) {
            return;
        }

        $this->title = (string) ($account->title ?? '');
        $this->recipient = (string) $account->recipient;
        $this->iban = (string) $account->iban;
        $this->bank_name = (string) $account->bank_name;
        $this->bank_mfo = (string) ($account->bank_mfo ?? '');
        $this->bank_edrpou = (string) ($account->bank_edrpou ?? '');
        $this->currency = (string) $account->currency;
        $this->payment_purpose_template = (string) ($account->payment_purpose_template ?? '');
        $this->is_default = (bool) $account->is_default;
        $this->is_active = (bool) $account->is_active;
    }

    public function save(SaveBankAccountAction $action): void
    {
        $validated = $this->validate([
            'title' => ['nullable', 'string', 'max:150'],
            'recipient' => ['required', 'string', 'max:255'],
            'iban' => ['required', 'string', 'max:64'],
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_mfo' => ['nullable', 'string', 'max:32'],
            'bank_edrpou' => ['nullable', 'string', 'max:32'],
            'currency' => ['required', 'string', 'max:10'],
            'payment_purpose_template' => ['nullable', 'string'],
            'is_default' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        $profile = BusinessProfile::query()->first();

        if (! $profile) {
            $message = 'Create business profile first.';
            $this->addError('recipient', $message);
            $this->dispatch('toast', type: 'error', message: $message);
            return;
        }

        $action->execute($profile, $validated);

        session()->flash('success', 'Bank account saved successfully.');
        $this->dispatch('toast', type: 'success', message: 'Bank account saved successfully.');
    }

    public function render(): View
    {
        return view('livewire.settings.bank-account-form');
    }
}
