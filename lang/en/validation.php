<?php

return [
    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute field must be a valid email address.',
    'numeric' => 'The :attribute field must be a number.',
    'max' => [
        'string' => 'The :attribute field must not be greater than :max characters.',
        'file' => 'The :attribute field must not be greater than :max kilobytes.',
    ],
    'min' => [
        'numeric' => 'The :attribute field must be at least :min.',
    ],
    'gt' => [
        'numeric' => 'The :attribute field must be greater than :value.',
    ],
    'mimes' => 'The :attribute field must be a file of type: :values.',
    'attributes' => [
        'full_name' => 'full name',
        'company_name' => 'company name',
        'phone' => 'phone',
        'client_id' => 'client',
        'item_name' => 'item name',
        'reported_problem' => 'reported problem',
        'status' => 'status',
        'amount' => 'amount',
        'file' => 'file',
        'category' => 'category',
        'method' => 'method',
        'type' => 'type',
    ],
];
