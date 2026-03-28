<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Requests;

use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeServiceOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(ServiceOrderStatus::values())],
            'comment' => ['nullable', 'string'],
        ];
    }
}
