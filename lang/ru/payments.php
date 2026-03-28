<?php

return [
    'title' => 'Платежи',
    'fields' => [
        'type' => 'Тип',
        'method' => 'Способ оплаты',
        'amount' => 'Сумма',
        'paid_at' => 'Дата оплаты',
        'comment' => 'Комментарий',
    ],
    'types' => [
        'payment' => 'Оплата',
        'refund' => 'Возврат',
    ],
    'methods' => [
        'cash' => 'Наличные',
        'card' => 'Карта',
        'bank_transfer' => 'Банковский перевод',
        'other' => 'Другое',
    ],
    'messages' => [
        'no_comment' => 'Без комментария',
    ],
];
