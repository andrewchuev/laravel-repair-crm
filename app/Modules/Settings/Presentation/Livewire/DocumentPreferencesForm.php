<?php

namespace App\Modules\Settings\Presentation\Livewire;

use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use App\Modules\Settings\Infrastructure\Persistence\Models\DocumentPreference;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DocumentPreferencesForm extends Component
{
    public ?int $documentPreferenceId = null;
    public string $invoice_prefix = 'INV';
    public string $intake_act_prefix = 'RIN';
    public string $completion_act_prefix = 'ACT';
    public string $repair_terms_uk = '';
    public string $storage_terms_uk = '';
    public string $diagnostic_terms_uk = '';
    public string $warranty_terms_uk = '';
    public string $invoice_footer_uk = '';
    public string $completion_act_footer_uk = '';

    public function mount(): void
    {
        $pref = DocumentPreference::query()->first();
        if (! $pref) return;
        $this->documentPreferenceId = $pref->id;
        foreach (['invoice_prefix','intake_act_prefix','completion_act_prefix','repair_terms_uk','storage_terms_uk','diagnostic_terms_uk','warranty_terms_uk','invoice_footer_uk','completion_act_footer_uk'] as $field) { $this->{$field} = (string) ($pref->{$field} ?? ''); }
    }

    public function save(): void
    {
        $profile = BusinessProfile::query()->where('is_active', true)->first() ?? BusinessProfile::query()->first();
        abort_unless($profile, 422, 'Спочатку заповніть профіль ФОП.');
        $validated = $this->validate([
            'invoice_prefix' => ['required','string','max:20'], 'intake_act_prefix' => ['required','string','max:20'], 'completion_act_prefix' => ['required','string','max:20'],
            'repair_terms_uk' => ['nullable','string'], 'storage_terms_uk' => ['nullable','string'], 'diagnostic_terms_uk' => ['nullable','string'],
            'warranty_terms_uk' => ['nullable','string'], 'invoice_footer_uk' => ['nullable','string'], 'completion_act_footer_uk' => ['nullable','string'],
        ]);
        $pref = $this->documentPreferenceId ? DocumentPreference::query()->findOrFail($this->documentPreferenceId) : new DocumentPreference();
        $pref->fill($validated + ['business_profile_id' => $profile->id, 'default_document_locale' => 'uk']);
        $pref->save(); $this->documentPreferenceId = $pref->id; session()->flash('success', 'Налаштування документів збережено.');
    }

    public function render(): View { return view('livewire.settings.document-preferences-form'); }
}
