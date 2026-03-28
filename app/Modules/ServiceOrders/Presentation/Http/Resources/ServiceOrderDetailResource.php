<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Resources;

use App\Modules\Clients\Presentation\Http\Resources\ClientResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOrderDetailResource extends JsonResource
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
            'brand' => $this->brand,
            'model' => $this->model,
            'serial_number' => $this->serial_number,
            'reported_problem' => $this->reported_problem,
            'intake_condition' => $this->intake_condition,
            'accessories' => $this->accessories,
            'intake_checklist' => $this->intake_checklist,
            'device_snapshot' => $this->device_snapshot,
            'diagnostic_summary' => $this->diagnostic_summary,
            'work_result' => $this->work_result,
            'internal_notes' => $this->internal_notes,
            'customer_notes' => $this->customer_notes,
            'estimated_price' => $this->estimated_price,
            'agreed_price' => $this->agreed_price,
            'final_price' => $this->final_price,
            'paid_amount' => $this->paid_amount,
            'balance_amount' => $this->balance_amount,
            'received_at' => $this->received_at,
            'promised_at' => $this->promised_at,
            'approved_at' => $this->approved_at,
            'ready_at' => $this->ready_at,
            'delivered_at' => $this->delivered_at,
            'warranty_until' => $this->warranty_until,
            'client' => new ClientResource($this->whenLoaded('client')),
            'accepted_by' => $this->whenLoaded('acceptedBy', fn () => [
                'id' => $this->acceptedBy?->id,
                'name' => $this->acceptedBy?->name,
            ]),
            'assigned_master' => $this->whenLoaded('assignedMaster', fn () => [
                'id' => $this->assignedMaster?->id,
                'name' => $this->assignedMaster?->name,
            ]),
            'items' => ServiceOrderItemResource::collection($this->whenLoaded('items')),
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
            'comments' => ServiceOrderCommentResource::collection($this->whenLoaded('comments')),
            'attachments' => ServiceOrderAttachmentResource::collection($this->whenLoaded('attachments')),
            'status_history' => ServiceOrderStatusHistoryResource::collection($this->whenLoaded('statusHistory')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
