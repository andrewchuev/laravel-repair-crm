<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOrderAttachmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type?->value,
            'type_label' => $this->type?->label(),
            'original_name' => $this->original_name,
            'mime_type' => $this->mime_type,
            'extension' => $this->extension,
            'size_bytes' => $this->size_bytes,
            'description' => $this->description,
            'is_primary' => $this->is_primary,
            'taken_at' => $this->taken_at,
            'created_at' => $this->created_at,
            'url' => null,
        ];
    }
}
