<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOrderStatusHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'old_status' => $this->old_status?->value,
            'old_status_label' => $this->old_status?->label(),
            'new_status' => $this->new_status?->value,
            'new_status_label' => $this->new_status?->label(),
            'comment' => $this->comment,
            'changed_by' => $this->whenLoaded('changedBy', fn () => [
                'id' => $this->changedBy?->id,
                'name' => $this->changedBy?->name,
            ]),
            'created_at' => $this->created_at,
        ];
    }
}
