<?php

namespace App\Modules\ServiceOrders\Application\Actions;

use App\Models\User;
use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadServiceOrderAttachmentAction
{
    public function __construct(
        private readonly LogActivityAction $logActivityAction,
    ) {
    }

    public function execute(ServiceOrder $serviceOrder, UploadedFile $file, array $data, User $actor): ServiceOrderAttachment
    {
        return DB::transaction(function () use ($serviceOrder, $file, $data, $actor) {
            $disk = $data['disk'] ?? config('filesystems.default', 'local');
            $directory = sprintf('service-orders/%d/attachments', $serviceOrder->id);
            $storedName = Str::uuid().'.'.$file->getClientOriginalExtension();
            $path = Storage::disk($disk)->putFileAs($directory, $file, $storedName);

            $attachment = ServiceOrderAttachment::create([
                'service_order_id' => $serviceOrder->id,
                'uploaded_by_user_id' => $actor->id,
                'type' => $data['type'],
                'original_name' => $file->getClientOriginalName(),
                'stored_name' => $storedName,
                'disk' => $disk,
                'path' => $path,
                'mime_type' => $file->getMimeType() ?? 'application/octet-stream',
                'extension' => $file->getClientOriginalExtension(),
                'size_bytes' => $file->getSize() ?: 0,
                'checksum' => hash_file('sha256', $file->getRealPath()),
                'description' => $data['description'] ?? null,
                'is_primary' => (bool) ($data['is_primary'] ?? false),
                'taken_at' => $data['taken_at'] ?? null,
                'meta' => [],
            ]);

            if ($attachment->is_primary) {
                $serviceOrder->attachments()
                    ->whereKeyNot($attachment->id)
                    ->update(['is_primary' => false]);
            }

            $this->logActivityAction->execute(
                entityType: 'service_order',
                entityId: $serviceOrder->id,
                action: 'attachment.uploaded',
                user: $actor,
                newValues: $attachment->toArray(),
            );

            return $attachment->refresh();
        });
    }
}
