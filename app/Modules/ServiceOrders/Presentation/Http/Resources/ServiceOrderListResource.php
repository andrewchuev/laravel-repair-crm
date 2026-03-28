<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOrderListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'status' => $this->status?->value,
            'status_label' => $this->status?->label(),
            'priority' => $this->priority?->value,
            'priority_label' => $this->priority?->label(),
            'category' => $this->category?->value,
            'category_label' => $this->category?->label(),
            'item_name' => $this->item_name,
            'client' => $this->whenLoaded('client', fn () => [
                'id' => $this->client?->id,
                'name' => $this->client?->displayName(),
                'phone' => $this->client?->phone,
            ]),
            'assigned_master' => $this->whenLoaded('assignedMaster', fn () => [
                'id' => $this->assignedMaster?->id,
                'name' => $this->assignedMaster?->name,
            ]),
            'final_price' => $this->final_price,
            'paid_amount' => $this->paid_amount,
            'balance_amount' => $this->balance_amount,
            'received_at' => $this->received_at,
            'ready_at' => $this->ready_at,
            'delivered_at' => $this->delivered_at,
        ];
    }
}
