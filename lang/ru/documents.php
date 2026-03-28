<?php

return [
    'page' => [
        'title' => 'Документы заказа',
        'subtitle' => 'Генерация и загрузка документов по заказу.',
    ],
    'panel' => [
        'title_for' => 'Документы для :number',
        'client_label' => 'Клиент: :name',
        'back_to_order' => 'Назад к заказу',
        'generate_documents' => 'Сформировать документы',
        'generated_documents' => 'Сформированные документы',
        'empty_title' => 'Документов пока нет.',
        'empty_description' => 'Используйте кнопки выше, чтобы создать первый документ.',
    ],
    'table' => [
        'type' => 'Тип',
        'number' => 'Номер',
        'date' => 'Дата',
        'status' => 'Статус',
    ],
    'actions' => [
        'generate_invoice' => 'Сформировать счёт',
        'generate_intake_act' => 'Сформировать акт приёмки',
        'generate_completion_act' => 'Сформировать акт выполненных работ',
        'html' => 'HTML',
        'pdf' => 'PDF',
        'void' => 'Аннулировать',
    ],
    'types' => [
        'invoice' => 'Счёт',
        'intake_act' => 'Акт приёмки',
        'completion_act' => 'Акт выполненных работ',
        'warranty_card' => 'Гарантийный талон',
        'diagnostic_act' => 'Акт диагностики',
    ],
    'status' => [
        'draft' => 'Черновик',
        'issued' => 'Выпущен',
        'voided' => 'Аннулирован',
    ],
];
