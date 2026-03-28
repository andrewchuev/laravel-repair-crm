<?php

return [
    'page' => [
        'title' => 'Документи замовлення',
        'subtitle' => 'Генерація та завантаження документів за замовленням.',
    ],
    'panel' => [
        'title_for' => 'Документи для :number',
        'client_label' => 'Клієнт: :name',
        'back_to_order' => 'Назад до замовлення',
        'generate_documents' => 'Сформувати документи',
        'generated_documents' => 'Сформовані документи',
        'empty_title' => 'Документів поки немає.',
        'empty_description' => 'Використайте кнопки вище, щоб створити перший документ.',
    ],
    'table' => [
        'type' => 'Тип',
        'number' => 'Номер',
        'date' => 'Дата',
        'status' => 'Статус',
    ],
    'actions' => [
        'generate_invoice' => 'Сформувати рахунок',
        'generate_intake_act' => 'Сформувати акт приймання',
        'generate_completion_act' => 'Сформувати акт виконаних робіт',
        'html' => 'HTML',
        'pdf' => 'PDF',
        'void' => 'Анулювати',
    ],
    'types' => [
        'invoice' => 'Рахунок',
        'intake_act' => 'Акт приймання',
        'completion_act' => 'Акт виконаних робіт',
        'warranty_card' => 'Гарантійний талон',
        'diagnostic_act' => 'Акт діагностики',
    ],
    'status' => [
        'draft' => 'Чернетка',
        'issued' => 'Випущено',
        'voided' => 'Анулювано',
    ],
];
