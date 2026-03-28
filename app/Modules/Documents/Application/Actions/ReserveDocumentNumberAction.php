<?php

namespace App\Modules\Documents\Application\Actions;

use App\Modules\Documents\Domain\Enums\DocumentType;
use App\Modules\Documents\Infrastructure\Persistence\Models\DocumentNumberCounter;
use App\Modules\Settings\Infrastructure\Persistence\Models\DocumentPreference;
use Illuminate\Support\Facades\DB;

class ReserveDocumentNumberAction
{
    public function execute(DocumentType $type, DocumentPreference $preferences): string
    {
        return DB::transaction(function () use ($type, $preferences): string {
            $year = (int) now()->format('Y');
            $field = $type->prefixField();
            $prefix = (string) ($preferences->{$field} ?: strtoupper(substr($type->value, 0, 3)));
            $counter = DocumentNumberCounter::query()->lockForUpdate()->firstOrCreate(
                ['document_type' => $type->value, 'year' => $year],
                ['prefix' => $prefix, 'last_number' => 0],
            );
            $counter->last_number++;
            $counter->prefix = $prefix;
            $counter->save();
            return sprintf('%s-%d-%06d', $counter->prefix, $year, $counter->last_number);
        });
    }
}
