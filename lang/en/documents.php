<?php

return [
    'page' => [
        'title' => 'Service Order Documents',
        'subtitle' => 'Generate and download order-related documents.',
    ],
    'panel' => [
        'title_for' => 'Documents for :number',
        'client_label' => 'Client: :name',
        'back_to_order' => 'Back to order',
        'generate_documents' => 'Generate documents',
        'generated_documents' => 'Generated documents',
        'empty_title' => 'No generated documents yet.',
        'empty_description' => 'Use the buttons above to create the first document.',
    ],
    'table' => [
        'type' => 'Type',
        'number' => 'Number',
        'date' => 'Date',
        'status' => 'Status',
    ],
    'actions' => [
        'generate_invoice' => 'Generate invoice',
        'generate_intake_act' => 'Generate intake act',
        'generate_completion_act' => 'Generate completion act',
        'html' => 'HTML',
        'pdf' => 'PDF',
        'void' => 'Void',
    ],
    'types' => [
        'invoice' => 'Invoice',
        'intake_act' => 'Intake act',
        'completion_act' => 'Completion act',
        'warranty_card' => 'Warranty card',
        'diagnostic_act' => 'Diagnostic act',
    ],
    'status' => [
        'draft' => 'Draft',
        'issued' => 'Issued',
        'voided' => 'Voided',
    ],
];
