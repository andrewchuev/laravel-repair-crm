<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type?->value,
            'type_label' => $this->type?->label(),
            'method' => $this->method?->value,
            'method_label' => $this->method?->label(),
            'amount' => $this->amount,
            'paid_at' => $this->paid_at,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
        ];
    }
}
