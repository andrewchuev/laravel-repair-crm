<?php

namespace App\Modules\Documents\Application\Actions;

use Illuminate\Support\Facades\Storage;

class RenderDocumentPdfAction
{
    public function execute(string $html, string $fileName, string $directory = 'documents/generated'): ?array
    {
        if (! app()->bound('dompdf.wrapper')) {
            return null;
        }
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($html);
        $contents = $pdf->output();
        $disk = 'public';
        $path = trim($directory, '/') . '/' . $fileName;
        Storage::disk($disk)->put($path, $contents);
        return ['disk' => $disk, 'path' => $path, 'file_name' => $fileName];
    }
}
