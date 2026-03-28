<?php

namespace App\Modules\Clients\Presentation\Http\Requests;

use App\Modules\Clients\Domain\Enums\ClientType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(ClientType::values())],
            'full_name' => ['nullable', 'string', 'max:200'],
            'company_name' => ['nullable', 'string', 'max:200'],
            'phone' => ['required', 'string', 'max:32'],
            'phone_secondary' => ['nullable', 'string', 'max:32'],
            'email' => ['nullable', 'email', 'max:150'],
            'notes' => ['nullable', 'string'],
            'source' => ['nullable', 'string', 'max:64'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $type = $this->input('type');

            if ($type === ClientType::PERSON->value && ! $this->filled('full_name')) {
                $validator->errors()->add('full_name', __('validation.required', ['attribute' => 'full_name']));
            }

            if ($type === ClientType::COMPANY->value && ! $this->filled('company_name')) {
                $validator->errors()->add('company_name', __('validation.required', ['attribute' => 'company_name']));
            }
        });
    }
}
