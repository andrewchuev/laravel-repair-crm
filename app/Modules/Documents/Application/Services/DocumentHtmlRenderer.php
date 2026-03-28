<?php

namespace App\Modules\Documents\Application\Services;

use App\Modules\Documents\Domain\Enums\DocumentType;

class DocumentHtmlRenderer
{
    public function render(DocumentType $type, array $payload): string
    {
        return view($type->bladeView(), ['document' => $payload])->render();
    }
}
