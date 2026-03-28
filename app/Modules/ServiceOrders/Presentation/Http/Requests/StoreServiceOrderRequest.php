<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Requests;

use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderCategory;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderPriority;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'assigned_master_id' => ['nullable', 'integer', 'exists:users,id'],
            'priority' => ['nullable', Rule::in(ServiceOrderPriority::values())],
            'category' => ['required', Rule::in(ServiceOrderCategory::values())],
            'item_name' => ['required', 'string', 'max:200'],
            'brand' => ['nullable', 'string', 'max:120'],
            'model' => ['nullable', 'string', 'max:120'],
            'serial_number' => ['nullable', 'string', 'max:120'],
            'reported_problem' => ['required', 'string'],
            'intake_condition' => ['nullable', 'string'],
            'accessories' => ['nullable', 'string'],
            'intake_checklist' => ['nullable', 'array'],
            'device_snapshot' => ['nullable', 'array'],
            'internal_notes' => ['nullable', 'string'],
            'customer_notes' => ['nullable', 'string'],
            'estimated_price' => ['nullable', 'numeric', 'min:0'],
            'agreed_price' => ['nullable', 'numeric', 'min:0'],
            'received_at' => ['nullable', 'date'],
            'promised_at' => ['nullable', 'date'],
            'warranty_until' => ['nullable', 'date'],
        ];
    }
}
