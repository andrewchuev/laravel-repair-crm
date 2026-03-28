<?php

return [
    'title' => 'Платежі',
    'fields' => [
        'type' => 'Тип',
        'method' => 'Спосіб оплати',
        'amount' => 'Сума',
        'paid_at' => 'Дата оплати',
        'comment' => 'Коментар',
    ],
    'types' => [
        'payment' => 'Оплата',
        'refund' => 'Повернення',
    ],
    'methods' => [
        'cash' => 'Готівка',
        'card' => 'Картка',
        'bank_transfer' => 'Банківський переказ',
        'other' => 'Інше',
    ],
    'messages' => [
        'no_comment' => 'Без коментаря',
    ],
];
