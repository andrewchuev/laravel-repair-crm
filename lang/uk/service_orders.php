<?php

return [
    'title' => 'Замовлення',

    'index' => [
        'title' => 'Замовлення',
        'subtitle' => 'Контроль активних, готових і завершених робіт.',
        'search_placeholder' => 'Пошук за номером, клієнтом, телефоном, серійним номером...',
        'all_statuses' => 'Усі статуси',
        'all_categories' => 'Усі категорії',
        'create_button' => 'Створити замовлення',
    ],

    'create' => [
        'title' => 'Створення замовлення',
        'subtitle' => 'Реєстрація нового приймання пристрою та створення ремонтного замовлення.',
        'select_client' => 'Оберіть клієнта',
        'create_button' => 'Створити замовлення',
    ],

    'show' => [
        'title' => 'Замовлення',
        'subtitle' => 'Інтерактивна сторінка замовлення з основними розділами.',
        'documents_button' => 'Документи',
    ],

    'fields' => [
        'order_number' => 'Order',
        'client' => 'Клієнт',
        'priority' => 'Пріоритет',
        'category' => 'Категорія',
        'item_name' => 'Пристрій',
        'brand' => 'Бренд',
        'model' => 'Модель',
        'serial_number' => 'Серійний номер',
        'reported_problem' => 'Заявлена несправність',
        'intake_condition' => 'Стан при прийманні',
        'accessories' => 'Комплектація',
        'diagnostic_summary' => 'Diagnostic summary',
        'work_result' => 'Work result',
        'internal_notes' => 'Internal notes',
        'customer_notes' => 'Customer notes',
        'estimated_price' => 'Estimated price',
        'agreed_price' => 'Agreed price',
        'final_price' => 'Підсумок',
        'paid_amount' => 'Сплачено',
        'balance_amount' => 'Залишок',
        'received_at' => 'Прийнято',
        'promised_at' => 'Promised at',
        'approved_at' => 'Approved at',
        'ready_at' => 'Ready at',
        'delivered_at' => 'Delivered at',
        'warranty_until' => 'Warranty until',
        'accepted_by' => 'Accepted by',
        'assigned_master' => 'Майстер',
        'position' => 'Позиція',
        'quantity' => 'К-сть',
        'unit_price' => 'Ціна',
        'cost_price' => 'Собівартість',
        'total_price' => 'Сума',
        'visibility' => 'Видимість',
        'body' => 'Коментар',
    ],

    'sections' => [
        'client' => 'Клієнт',
        'device_problem' => 'Пристрій і проблема',
        'status' => 'Статус',
        'comments' => 'Коментарі',
        'attachments' => 'Вкладення',
        'works_parts' => 'Роботи та запчастини',
        'payments' => 'Платежі',
        'status_history' => 'Історія статусів',
        'add_comment' => 'Додати коментар',
        'add_item' => 'Додати позицію',
        'record_payment' => 'Зареєструвати платіж',
        'upload_attachment' => 'Завантажити вкладення',
    ],

    'actions' => [
        'update_status' => 'Оновити статус',
        'save_payment' => 'Зберегти платіж',
    ],

    'generic' => [
        'current' => 'Поточний',
        'next_status' => 'Наступний статус',
        'select_status' => 'Оберіть статус',
        'name' => 'Назва',
        'description' => 'Опис',
        'unit_short' => 'Од.',
    ],

    'empty' => [
        'orders_title' => 'Замовлень ще немає.',
        'orders_description' => 'Створіть перше замовлення, щоб почати вести роботу майстерні.',
        'items_title' => 'Позицій поки немає.',
        'items_description' => 'Додайте нижче роботи або запчастини.',
        'comments_title' => 'Коментарів поки немає.',
        'comments_description' => 'Додайте нижче внутрішні або публічні нотатки.',
        'payments_title' => 'Платежів поки немає.',
        'payments_description' => 'Зареєструйте перший платіж нижче.',
        'history_title' => 'Історія статусів поки порожня.',
        'history_description' => 'Зміни статусу будуть показані тут.',
    ],

    'counts' => [
        'events' => ':count подія(й)',
    ],

    'confirm_delete_item' => 'Видалити цю позицію?',

    'status' => [
        'new' => 'Нове',
        'diagnostics' => 'Діагностика',
        'awaiting_approval' => 'Очікує погодження',
        'approved' => 'Погоджено',
        'in_progress' => 'В роботі',
        'waiting_parts' => 'Очікує запчастину',
        'ready' => 'Готово',
        'delivered' => 'Видано',
        'cancelled' => 'Скасовано',
    ],

    'priority' => [
        'low' => 'Низький',
        'normal' => 'Звичайний',
        'high' => 'Високий',
        'urgent' => 'Терміновий',
    ],

    'category' => [
        'computer' => 'Компʼютер',
        'desktop' => 'Настільний ПК',
        'laptop' => 'Ноутбук',
        'printer' => 'Принтер',
        'mfp' => 'МФУ',
        'tablet' => 'Планшет',
        'monitor' => 'Монітор',
        'network' => 'Мережеве обладнання',
        'networking' => 'Мережеве обладнання',
        'cartridge' => 'Картридж',
        'server' => 'Сервер',
        'other' => 'Інше',
    ],

    'item_type' => [
        'work' => 'Робота',
        'part' => 'Запчастина',
        'service' => 'Послуга',
        'discount' => 'Знижка',
    ],

    'comment_visibility' => [
        'internal' => 'Внутрішній',
        'public' => 'Публічний',
        'customer' => 'Для клієнта',
    ],

    'device_editor' => [
        'actions' => [
            'edit' => 'Редагувати',
            'save' => 'Зберегти зміни',
            'cancel' => 'Скасувати',
        ],
        'messages' => [
            'saved' => 'Дані про пристрій і проблему успішно оновлено.',
            'locked' => 'Цей блок більше не можна редагувати.',
            'read_only' => 'Для вашої ролі це замовлення в поточному статусі доступне лише для читання.',
        ],
    ],

    'messages' => [
        'no_further_transitions' => 'Більше немає доступних переходів статусу.',
        'system' => 'Система',
    ],
];
