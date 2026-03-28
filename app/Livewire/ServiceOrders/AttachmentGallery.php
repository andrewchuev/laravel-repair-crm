<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderAttachment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class AttachmentGallery extends Component
{
    public int $serviceOrderId;

    #[On('service-order-updated')]
    public function refreshGallery(): void
    {
        //
    }

    public function deleteAttachment(int $attachmentId): void
    {
        $attachment = ServiceOrderAttachment::query()
            ->where('service_order_id', $this->serviceOrderId)
            ->findOrFail($attachmentId);

        DB::transaction(function () use ($attachment): void {
            try {
                Storage::disk($attachment->disk)->delete($attachment->path);
            } catch (\Throwable $e) {
                // Ignore storage delete errors for now; record deletion still proceeds.
            }

            $attachment->delete();
        });

        $this->dispatch('service-order-updated');
    }

    public function markPrimary(int $attachmentId): void
    {
        DB::transaction(function () use ($attachmentId): void {
            ServiceOrderAttachment::query()
                ->where('service_order_id', $this->serviceOrderId)
                ->update(['is_primary' => false]);

            ServiceOrderAttachment::query()
                ->where('service_order_id', $this->serviceOrderId)
                ->whereKey($attachmentId)
                ->update(['is_primary' => true]);
        });

        $this->dispatch('service-order-updated');
    }

    public function render(): View
    {
        $order = ServiceOrder::query()
            ->with('attachments')
            ->findOrFail($this->serviceOrderId);

        $attachments = $order->attachments()
            ->orderByDesc('is_primary')
            ->latest('id')
            ->get()
            ->map(function ($attachment) {
                $mime = (string) ($attachment->mime_type ?? '');
                $isImage = str_starts_with($mime, 'image/');
                $url = null;

                try {
                    $url = Storage::disk($attachment->disk)->url($attachment->path);
                } catch (\Throwable $e) {
                    $url = null;
                }

                return [
                    'id' => $attachment->id,
                    'type' => $attachment->type->value ?? $attachment->type,
                    'original_name' => $attachment->original_name,
                    'description' => $attachment->description,
                    'mime_type' => $mime,
                    'is_image' => $isImage,
                    'is_primary' => (bool) $attachment->is_primary,
                    'size_bytes' => (int) ($attachment->size_bytes ?? 0),
                    'created_at' => optional($attachment->created_at)?->format('d.m.Y H:i'),
                    'url' => $url,
                ];
            });

        return view('livewire.service-orders.attachment-gallery', [
            'attachments' => $attachments,
        ]);
    }
}
