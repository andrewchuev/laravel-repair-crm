<?php

namespace App\Modules\Documents\Application\Actions;

use App\Modules\Documents\Domain\Enums\DocumentType;
use Illuminate\Support\Facades\View;

class RenderDocumentHtmlAction
{
    public function execute(DocumentType $type, array $snapshot): string
    {
        return View::make($type->view(), ['snapshot' => $snapshot, 'documentType' => $type])->render();
    }
}
