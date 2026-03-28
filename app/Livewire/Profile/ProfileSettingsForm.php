<?php

namespace App\Livewire\Profile;

use App\Shared\Domain\Enums\SupportedLocale;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ProfileSettingsForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $preferred_locale = 'en';

    public function mount(): void
    {
        $user = Auth::user();

        $this->name = (string) ($user->name ?? '');
        $this->email = (string) ($user->email ?? '');

        $this->preferred_locale = match (true) {
            $user->preferred_locale instanceof \BackedEnum => $user->preferred_locale->value,
            filled($user->preferred_locale) => (string) $user->preferred_locale,
            default => 'en',
        };
    }

    public function save(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'preferred_locale' => ['required', Rule::in(['en', 'ru', 'uk'])],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->preferred_locale = SupportedLocale::from($validated['preferred_locale']);
        $user->save();

        session()->flash('success', __('profile.messages.saved'));
        $this->dispatch('toast', type: 'success', message: __('profile.messages.saved'));
    }

    public function render(): View
    {
        return view('livewire.profile.profile-settings-form', [
            'availableLocales' => [
                'en' => __('common.locales.en'),
                'ru' => __('common.locales.ru'),
                'uk' => __('common.locales.uk'),
            ],
        ]);
    }
}
