<?php

namespace App\Modules\Documents\Domain\Enums;

enum DocumentType: string
{
    case Invoice = 'invoice';
    case IntakeAct = 'intake_act';
    case CompletionAct = 'completion_act';
    case WarrantyCard = 'warranty_card';
    case DiagnosticAct = 'diagnostic_act';

    public function bladeView(): string
    {
        return match ($this) {
            self::Invoice => 'documents.invoice',
            self::IntakeAct => 'documents.intake-act',
            self::CompletionAct => 'documents.completion-act',
            self::WarrantyCard => 'documents.completion-act',
            self::DiagnosticAct => 'documents.intake-act',
        };
    }
}
