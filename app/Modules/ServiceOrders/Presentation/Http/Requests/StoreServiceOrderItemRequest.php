<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Requests;

use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderItemType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceOrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(ServiceOrderItemType::values())],
            'name' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'numeric', 'gt:0'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'position' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
