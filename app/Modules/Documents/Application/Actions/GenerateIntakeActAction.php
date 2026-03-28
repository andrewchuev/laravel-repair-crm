<?php

namespace App\Modules\Documents\Application\Actions;

use App\Modules\Documents\Application\Services\DocumentHtmlRenderer;
use App\Modules\Documents\Application\Services\DocumentNumberGenerator;
use App\Modules\Documents\Application\Services\DocumentPdfRenderer;
use App\Modules\Documents\Application\Services\DocumentSnapshotBuilder;
use App\Modules\Documents\Domain\Enums\DocumentType;
use App\Modules\Documents\Domain\Enums\GeneratedDocumentStatus;
use App\Modules\Documents\Infrastructure\Persistence\Models\GeneratedDocument;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\Settings\Infrastructure\Persistence\Models\BankAccount;
use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class GenerateIntakeActAction
{
    public function __construct(
        private readonly DocumentNumberGenerator $numberGenerator,
        private readonly DocumentSnapshotBuilder $snapshotBuilder,
        private readonly DocumentHtmlRenderer $htmlRenderer,
        private readonly DocumentPdfRenderer $pdfRenderer,
    ) {}

    public function execute(ServiceOrder $serviceOrder, ?int $issuedByUserId = null): GeneratedDocument
    {
        $profile = BusinessProfile::query()->where('is_active', true)->first();

        if (! $profile) {
            throw new RuntimeException('Active business profile is not configured.');
        }

        $bankAccount = BankAccount::query()
            ->where('business_profile_id', $profile->id)
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->first();

        return DB::transaction(function () use ($serviceOrder, $profile, $bankAccount, $issuedByUserId) {
            $type = DocumentType::IntakeAct;
            $number = $this->numberGenerator->next($profile, $type);
            $snapshot = $this->snapshotBuilder->build($serviceOrder, $profile, $bankAccount);

            $payload = [
                'type' => $type->value,
                'number' => $number,
                'date' => now()->format('d.m.Y'),
                'locale' => 'uk',
                'snapshot' => $snapshot,
            ];

            $document = GeneratedDocument::query()->create([
                'service_order_id' => $serviceOrder->id,
                'business_profile_id' => $profile->id,
                'bank_account_id' => $bankAccount?->id,
                'document_type' => $type->value,
                'document_number' => $number,
                'document_date' => now()->toDateString(),
                'locale' => 'uk',
                'status' => GeneratedDocumentStatus::Issued->value,
                'snapshot_json' => $payload,
                'issued_by_user_id' => $issuedByUserId,
                'issued_at' => now(),
            ]);

            $html = $this->htmlRenderer->render($type, $payload);
            $htmlPath = 'documents/html/' . $type->value . '/' . $number . '.html';

            Storage::disk('local')->put($htmlPath, $html);

            $document->html_disk = 'local';
            $document->html_path = $htmlPath;

            $pdfPath = 'documents/pdf/' . $type->value . '/' . $number . '.pdf';
            $pdfResult = $this->pdfRenderer->renderAndStore($html, 'local', $pdfPath);

            if ($pdfResult) {
                $document->pdf_disk = $pdfResult['pdf_disk'];
                $document->pdf_path = $pdfResult['pdf_path'];
            }

            $document->save();

            return $document->fresh();
        });
    }
}
