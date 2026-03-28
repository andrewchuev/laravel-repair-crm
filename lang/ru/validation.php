<?php

return [
    'required' => 'Поле :attribute обязательно для заполнения.',
    'email' => 'Поле :attribute должно содержать корректный email адрес.',
    'numeric' => 'Поле :attribute должно быть числом.',
    'max' => [
        'string' => 'Поле :attribute не должно быть длиннее :max символов.',
        'file' => 'Поле :attribute не должно быть больше :max килобайт.',
    ],
    'min' => [
        'numeric' => 'Поле :attribute должно быть не меньше :min.',
    ],
    'gt' => [
        'numeric' => 'Поле :attribute должно быть больше :value.',
    ],
    'mimes' => 'Поле :attribute должно быть файлом одного из типов: :values.',
    'attributes' => [
        'full_name' => 'полное имя',
        'company_name' => 'название компании',
        'phone' => 'телефон',
        'client_id' => 'клиент',
        'item_name' => 'устройство',
        'reported_problem' => 'заявленная неисправность',
        'status' => 'статус',
        'amount' => 'сумма',
        'file' => 'файл',
        'category' => 'категория',
        'method' => 'способ оплаты',
        'type' => 'тип',
    ],
];
