<?php

namespace App\Modules\Documents\Application\Services;

use Illuminate\Support\Facades\Storage;

class DocumentPdfRenderer
{
    public function renderAndStore(string $html, string $disk, string $path): ?array
    {
        if (! class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
            return null;
        }

        Storage::disk($disk)->makeDirectory(dirname($path));

        $absolutePath = Storage::disk($disk)->path($path);

        \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->save($absolutePath);

        return [
            'pdf_disk' => $disk,
            'pdf_path' => $path,
        ];
    }
}
