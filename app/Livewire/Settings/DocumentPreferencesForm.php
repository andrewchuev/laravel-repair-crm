<?php

namespace App\Livewire\Settings;

use App\Modules\Settings\Application\Actions\SaveDocumentSettingAction;
use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use App\Modules\Settings\Infrastructure\Persistence\Models\DocumentSetting;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DocumentPreferencesForm extends Component
{
    public string $document_locale = 'uk';
    public string $invoice_prefix = 'РХ';
    public string $intake_act_prefix = 'АР';
    public string $completion_act_prefix = 'АВР';
    public string $warranty_prefix = 'ГТ';
    public string $number_format = '{prefix}-{year}-{seq}';
    public string $default_city = '';
    public string $invoice_footer = '';
    public string $intake_terms = '';
    public string $completion_terms = '';
    public string $warranty_terms = '';
    public string $storage_terms = '';

    public function mount(): void
    {
        $setting = DocumentSetting::query()->first();

        if (! $setting) {
            return;
        }

        foreach ($this->fieldNames() as $field) {
            $this->{$field} = (string) ($setting->{$field} ?? '');
        }
    }

    public function save(SaveDocumentSettingAction $action): void
    {
        $validated = $this->validate([
            'document_locale' => ['required', 'string', 'max:10'],
            'invoice_prefix' => ['required', 'string', 'max:20'],
            'intake_act_prefix' => ['required', 'string', 'max:20'],
            'completion_act_prefix' => ['required', 'string', 'max:20'],
            'warranty_prefix' => ['required', 'string', 'max:20'],
            'number_format' => ['required', 'string', 'max:50'],
            'default_city' => ['nullable', 'string', 'max:100'],
            'invoice_footer' => ['nullable', 'string'],
            'intake_terms' => ['nullable', 'string'],
            'completion_terms' => ['nullable', 'string'],
            'warranty_terms' => ['nullable', 'string'],
            'storage_terms' => ['nullable', 'string'],
        ]);

        $profile = BusinessProfile::query()->first();

        if (! $profile) {
            $message = 'Create business profile first.';
            $this->addError('document_locale', $message);
            $this->dispatch('toast', type: 'error', message: $message);
            return;
        }

        $action->execute($profile, $validated);

        session()->flash('success', 'Document settings saved successfully.');
        $this->dispatch('toast', type: 'success', message: 'Document settings saved successfully.');
    }

    public function render(): View
    {
        return view('livewire.settings.document-preferences-form');
    }

    private function fieldNames(): array
    {
        return ['document_locale','invoice_prefix','intake_act_prefix','completion_act_prefix','warranty_prefix','number_format','default_city','invoice_footer','intake_terms','completion_terms','warranty_terms','storage_terms'];
    }
}
