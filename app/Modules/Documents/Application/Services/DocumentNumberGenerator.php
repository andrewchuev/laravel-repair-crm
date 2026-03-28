<?php

namespace App\Modules\Documents\Application\Services;

use App\Modules\Documents\Domain\Enums\DocumentType;
use App\Modules\Documents\Infrastructure\Persistence\Models\DocumentCounter;
use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use App\Modules\Settings\Infrastructure\Persistence\Models\DocumentSetting;
use Illuminate\Support\Facades\DB;

class DocumentNumberGenerator
{
    public function next(BusinessProfile $profile, DocumentType $type): string
    {
        return DB::transaction(function () use ($profile, $type) {
            $year = (int) now()->format('Y');

            $counter = DocumentCounter::query()
                ->where('business_profile_id', $profile->id)
                ->where('document_type', $type->value)
                ->where('year', $year)
                ->lockForUpdate()
                ->first();

            if (! $counter) {
                $counter = DocumentCounter::query()->create([
                    'business_profile_id' => $profile->id,
                    'document_type' => $type->value,
                    'year' => $year,
                    'current_number' => 0,
                ]);
            }

            $counter->current_number++;
            $counter->save();

            $settings = DocumentSetting::query()->where('business_profile_id', $profile->id)->first();

            $prefix = match ($type) {
                DocumentType::Invoice => $settings?->invoice_prefix ?? 'РХ',
                DocumentType::IntakeAct => $settings?->intake_act_prefix ?? 'АР',
                DocumentType::CompletionAct => $settings?->completion_act_prefix ?? 'АВР',
                DocumentType::WarrantyCard => $settings?->warranty_prefix ?? 'ГТ',
                default => strtoupper($type->value),
            };

            return sprintf('%s-%s-%06d', $prefix, $year, $counter->current_number);
        });
    }
}
