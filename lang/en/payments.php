<?php

return [
    'title' => 'Payments',
    'fields' => [
        'type' => 'Type',
        'method' => 'Method',
        'amount' => 'Amount',
        'paid_at' => 'Paid at',
        'comment' => 'Comment',
    ],
    'types' => [
        'payment' => 'Payment',
        'refund' => 'Refund',
    ],
    'methods' => [
        'cash' => 'Cash',
        'card' => 'Card',
        'bank_transfer' => 'Bank transfer',
        'other' => 'Other',
    ],
    'messages' => [
        'no_comment' => 'No comment',
    ],
];
