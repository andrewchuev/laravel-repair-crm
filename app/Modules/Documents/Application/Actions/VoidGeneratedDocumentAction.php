<?php

namespace App\Modules\Documents\Application\Actions;

use App\Modules\Documents\Domain\Enums\GeneratedDocumentStatus;
use App\Modules\Documents\Infrastructure\Persistence\Models\GeneratedDocument;

class VoidGeneratedDocumentAction
{
    public function execute(GeneratedDocument $document, ?int $voidedByUserId = null, ?string $reason = null): GeneratedDocument
    {
        $document->status = GeneratedDocumentStatus::Voided;
        $document->voided_by_user_id = $voidedByUserId;
        $document->void_reason = $reason;
        $document->voided_at = now();
        $document->save();

        return $document->fresh();
    }
}
