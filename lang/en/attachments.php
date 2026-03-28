<?php

return [
    'title' => 'Attachments',
    'upload_title' => 'Upload attachment',
    'count_label' => ':count file(s)',
    'file_fallback' => 'File',
    'confirm_delete' => 'Delete this attachment?',
    'fields' => [
        'type' => 'Type',
        'file' => 'File',
        'description' => 'Description',
        'is_primary' => 'Mark as primary attachment',
    ],
    'empty' => [
        'title' => 'No attachments yet.',
        'description' => 'Upload the first photo or document below.',
    ],
    'actions' => [
        'open' => 'Open',
        'preview' => 'Preview',
        'mark_primary' => 'Mark primary',
        'primary' => 'Primary',
    ],
    'upload_help' => [
        'allowed_formats' => 'Allowed: jpg, png, webp, pdf, doc, docx, xls, xlsx, txt. Max 15 MB.',
        'uploading' => 'Uploading file...',
    ],
    'types' => [
        'intake_photo' => 'Intake photo',
        'damage_photo' => 'Damage photo',
        'serial_photo' => 'Serial photo',
        'diagnostic_photo' => 'Diagnostic photo',
        'repair_photo' => 'Repair photo',
        'final_photo' => 'Final photo',
        'document' => 'Document',
        'receipt' => 'Receipt',
        'warranty' => 'Warranty',
        'other' => 'Other',
    ],
];
