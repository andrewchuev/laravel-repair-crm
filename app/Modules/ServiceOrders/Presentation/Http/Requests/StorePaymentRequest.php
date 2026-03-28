<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Requests;

use App\Modules\ServiceOrders\Domain\Enums\PaymentMethod;
use App\Modules\ServiceOrders\Domain\Enums\PaymentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(PaymentType::values())],
            'method' => ['required', Rule::in(PaymentMethod::values())],
            'amount' => ['required', 'numeric', 'gt:0'],
            'paid_at' => ['nullable', 'date'],
            'comment' => ['nullable', 'string'],
        ];
    }
}
