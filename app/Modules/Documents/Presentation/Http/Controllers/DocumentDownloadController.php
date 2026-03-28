<?php

namespace App\Modules\Documents\Presentation\Http\Controllers;

use App\Modules\Documents\Infrastructure\Persistence\Models\GeneratedDocument;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentDownloadController
{
    public function html(GeneratedDocument $generatedDocument): Response|StreamedResponse
    {
        abort_unless($generatedDocument->html_disk && $generatedDocument->html_path, 404);

        return Storage::disk($generatedDocument->html_disk)
            ->download($generatedDocument->html_path, basename($generatedDocument->html_path), [
                'Content-Type' => 'text/html; charset=UTF-8',
            ]);
    }

    public function pdf(GeneratedDocument $generatedDocument): Response|StreamedResponse
    {
        abort_unless($generatedDocument->pdf_disk && $generatedDocument->pdf_path, 404);

        return Storage::disk($generatedDocument->pdf_disk)
            ->download($generatedDocument->pdf_path, basename($generatedDocument->pdf_path), [
                'Content-Type' => 'application/pdf',
            ]);
    }
}
