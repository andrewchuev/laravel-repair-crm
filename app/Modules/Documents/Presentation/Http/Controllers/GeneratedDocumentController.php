<?php

namespace App\Modules\Documents\Presentation\Http\Controllers;

use App\Modules\Documents\Infrastructure\Persistence\Models\GeneratedDocument;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GeneratedDocumentController
{
    public function download(GeneratedDocument $generatedDocument): StreamedResponse
    {
        abort_unless($generatedDocument->disk && $generatedDocument->path, 404);
        $disk = Storage::disk($generatedDocument->disk);
        abort_unless($disk->exists($generatedDocument->path), 404);
        return $disk->download($generatedDocument->path, $generatedDocument->file_name ?: basename($generatedDocument->path));
    }
}
