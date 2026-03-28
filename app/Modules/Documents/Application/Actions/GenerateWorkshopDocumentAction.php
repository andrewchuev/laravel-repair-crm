<?php

namespace App\Modules\Documents\Application\Actions;

use App\Modules\Documents\Domain\Enums\DocumentStatus;
use App\Modules\Documents\Domain\Enums\DocumentType;
use App\Modules\Documents\Infrastructure\Persistence\Models\GeneratedDocument;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use Illuminate\Support\Facades\DB;

class GenerateWorkshopDocumentAction
{
    public function __construct(
        private readonly ReserveDocumentNumberAction $reserveNumber,
        private readonly BuildDocumentSnapshotAction $buildSnapshot,
        private readonly RenderDocumentHtmlAction $renderHtml,
        private readonly RenderDocumentPdfAction $renderPdf,
    ) {
    }

    public function execute(DocumentType $type, ServiceOrder $order, int $userId): GeneratedDocument
    {
        $profile = BusinessProfile::query()->where('is_active', true)->firstOrFail();
        $bankAccount = $profile->defaultBankAccount()->first();
        $preferences = $profile->documentPreference()->firstOrFail();
        $number = $this->reserveNumber->execute($type, $preferences);
        $snapshot = $this->buildSnapshot->execute($type, $order, $profile, $bankAccount, $preferences, $number);
        $html = $this->renderHtml->execute($type, $snapshot);
        $pdf = $this->renderPdf->execute($html, $number . '.pdf');

        return DB::transaction(function () use ($type, $order, $profile, $bankAccount, $number, $snapshot, $html, $pdf, $userId) {
            return GeneratedDocument::query()->create([
                'service_order_id' => $order->id,
                'business_profile_id' => $profile->id,
                'bank_account_id' => $bankAccount?->id,
                'type' => $type->value,
                'document_status' => DocumentStatus::ISSUED->value,
                'document_number' => $number,
                'document_date' => now()->toDateString(),
                'locale' => 'uk',
                'template_version' => 1,
                'payload_snapshot' => $snapshot,
                'html_snapshot' => $html,
                'file_name' => $pdf['file_name'] ?? null,
                'disk' => $pdf['disk'] ?? null,
                'path' => $pdf['path'] ?? null,
                'generated_by_user_id' => $userId,
                'issued_at' => now(),
            ]);
        });
    }
}
