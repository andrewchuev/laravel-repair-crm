<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Requests;

use App\Modules\ServiceOrders\Domain\Enums\CommentVisibility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceOrderCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'visibility' => ['required', Rule::in(CommentVisibility::values())],
            'body' => ['required', 'string'],
        ];
    }
}
