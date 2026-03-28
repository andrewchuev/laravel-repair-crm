<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderAttachment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AttachmentUpload extends Component
{
    use WithFileUploads;

    public int $serviceOrderId;

    public string $type = 'intake_photo';
    public string $description = '';
    public bool $is_primary = false;
    public $file;

    public function save(): void
    {
        $this->validate([
            'type' => ['required', 'string', 'in:intake_photo,damage_photo,serial_photo,diagnostic_photo,repair_photo,final_photo,document,receipt,warranty,other'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_primary' => ['boolean'],
            'file' => ['required', 'file', 'max:15360', 'mimes:jpg,jpeg,png,webp,pdf,doc,docx,xls,xlsx,txt'],
        ]);

        $order = ServiceOrder::query()->findOrFail($this->serviceOrderId);

        $originalName = (string) $this->file->getClientOriginalName();
        $extension = (string) $this->file->getClientOriginalExtension();
        $mimeType = (string) $this->file->getMimeType();
        $sizeBytes = (int) $this->file->getSize();
        $realPath = $this->file->getRealPath();
        $checksum = $realPath ? hash_file('sha256', $realPath) : null;

        $disk = 'public';
        $storedPath = $this->file->store('service-orders/' . $order->id . '/attachments', $disk);

        DB::transaction(function () use ($order, $originalName, $extension, $mimeType, $sizeBytes, $checksum, $disk, $storedPath): void {
            if ($this->is_primary) {
                ServiceOrderAttachment::query()
                    ->where('service_order_id', $order->id)
                    ->update(['is_primary' => false]);
            }

            ServiceOrderAttachment::query()->create([
                'service_order_id' => $order->id,
                'uploaded_by_user_id' => auth()->id(),
                'type' => $this->type,
                'original_name' => $originalName,
                'stored_name' => basename($storedPath),
                'disk' => $disk,
                'path' => $storedPath,
                'mime_type' => $mimeType,
                'extension' => $extension ?: null,
                'size_bytes' => $sizeBytes,
                'checksum' => $checksum,
                'description' => $this->description ?: null,
                'is_primary' => $this->is_primary,
                'taken_at' => str_starts_with($mimeType, 'image/') ? now() : null,
                'meta' => [
                    'uploaded_via' => 'livewire',
                ],
            ]);
        });

        $this->resetForm();
        $this->dispatch('service-order-updated');
    }

    public function render(): View
    {
        return view('livewire.service-orders.attachment-upload');
    }

    private function resetForm(): void
    {
        $this->type = 'intake_photo';
        $this->description = '';
        $this->is_primary = false;
        $this->reset('file');
    }
}
