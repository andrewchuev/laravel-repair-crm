<?php

return [
    'title' => 'Заказы',

    'index' => [
        'title' => 'Заказы',
        'subtitle' => 'Контроль активных, готовых и завершённых работ.',
        'search_placeholder' => 'Поиск по номеру, клиенту, телефону, серийному номеру...',
        'all_statuses' => 'Все статусы',
        'all_categories' => 'Все категории',
        'create_button' => 'Создать заказ',
    ],

    'create' => [
        'title' => 'Создание заказа',
        'subtitle' => 'Регистрация нового приёма устройства и создание ремонтного заказа.',
        'select_client' => 'Выберите клиента',
        'create_button' => 'Создать заказ',
    ],

    'show' => [
        'title' => 'Заказ',
        'subtitle' => 'Интерактивная страница заказа с основными разделами.',
        'documents_button' => 'Документы',
    ],

    'fields' => [
        'order_number' => 'Order',
        'client' => 'Клиент',
        'priority' => 'Приоритет',
        'category' => 'Категория',
        'item_name' => 'Устройство',
        'brand' => 'Бренд',
        'model' => 'Модель',
        'serial_number' => 'Серийный номер',
        'reported_problem' => 'Заявленная неисправность',
        'intake_condition' => 'Состояние при приёмке',
        'accessories' => 'Комплектация',
        'diagnostic_summary' => 'Diagnostic summary',
        'work_result' => 'Work result',
        'internal_notes' => 'Internal notes',
        'customer_notes' => 'Customer notes',
        'estimated_price' => 'Estimated price',
        'agreed_price' => 'Agreed price',
        'final_price' => 'Итого',
        'paid_amount' => 'Оплачено',
        'balance_amount' => 'Остаток',
        'received_at' => 'Принято',
        'promised_at' => 'Promised at',
        'approved_at' => 'Approved at',
        'ready_at' => 'Ready at',
        'delivered_at' => 'Delivered at',
        'warranty_until' => 'Warranty until',
        'accepted_by' => 'Accepted by',
        'assigned_master' => 'Мастер',
        'position' => 'Позиция',
        'quantity' => 'Кол-во',
        'unit_price' => 'Цена',
        'cost_price' => 'Себестоимость',
        'total_price' => 'Сумма',
        'visibility' => 'Видимость',
        'body' => 'Комментарий',
    ],

    'sections' => [
        'client' => 'Клиент',
        'device_problem' => 'Устройство и проблема',
        'status' => 'Статус',
        'comments' => 'Комментарии',
        'attachments' => 'Вложения',
        'works_parts' => 'Работы и запчасти',
        'payments' => 'Платежи',
        'status_history' => 'История статусов',
        'add_comment' => 'Добавить комментарий',
        'add_item' => 'Добавить позицию',
        'record_payment' => 'Зарегистрировать платёж',
        'upload_attachment' => 'Загрузить вложение',
    ],

    'actions' => [
        'update_status' => 'Обновить статус',
        'save_payment' => 'Сохранить платёж',
    ],

    'generic' => [
        'current' => 'Текущий',
        'next_status' => 'Следующий статус',
        'select_status' => 'Выберите статус',
        'name' => 'Название',
        'description' => 'Описание',
        'unit_short' => 'Ед.',
    ],

    'empty' => [
        'orders_title' => 'Заказов пока нет.',
        'orders_description' => 'Создайте первый заказ, чтобы начать вести работу мастерской.',
        'items_title' => 'Позиции пока отсутствуют.',
        'items_description' => 'Добавьте ниже работы или запчасти.',
        'comments_title' => 'Комментариев пока нет.',
        'comments_description' => 'Добавьте ниже внутренние или публичные заметки.',
        'payments_title' => 'Платежей пока нет.',
        'payments_description' => 'Зарегистрируйте первый платёж ниже.',
        'history_title' => 'История статусов пока пуста.',
        'history_description' => 'Изменения статуса будут показаны здесь.',
    ],

    'counts' => [
        'events' => ':count событие(й)',
    ],

    'confirm_delete_item' => 'Удалить эту позицию?',

    'status' => [
        'new' => 'Новый',
        'diagnostics' => 'Диагностика',
        'awaiting_approval' => 'Ожидает согласования',
        'approved' => 'Согласовано',
        'in_progress' => 'В работе',
        'waiting_parts' => 'Ожидает запчасти',
        'ready' => 'Готов',
        'delivered' => 'Выдан',
        'cancelled' => 'Отменён',
    ],

    'priority' => [
        'low' => 'Низкий',
        'normal' => 'Обычный',
        'high' => 'Высокий',
        'urgent' => 'Срочный',
    ],

    'category' => [
        'computer' => 'Компьютер',
        'desktop' => 'Настольный ПК',
        'laptop' => 'Ноутбук',
        'printer' => 'Принтер',
        'mfp' => 'МФУ',
        'tablet' => 'Планшет',
        'monitor' => 'Монитор',
        'network' => 'Сетевое оборудование',
        'networking' => 'Сетевое оборудование',
        'cartridge' => 'Картридж',
        'server' => 'Сервер',
        'other' => 'Другое',
    ],

    'item_type' => [
        'work' => 'Работа',
        'part' => 'Запчасть',
        'service' => 'Услуга',
        'discount' => 'Скидка',
    ],

    'comment_visibility' => [
        'internal' => 'Внутренний',
        'public' => 'Публичный',
        'customer' => 'Для клиента',
    ],

    'device_editor' => [
        'actions' => [
            'edit' => 'Редактировать',
            'save' => 'Сохранить изменения',
            'cancel' => 'Отмена',
        ],
        'messages' => [
            'saved' => 'Данные по устройству и проблеме успешно обновлены.',
            'locked' => 'Этот блок больше нельзя редактировать.',
            'read_only' => 'Для вашей роли этот заказ в текущем статусе доступен только для чтения.',
        ],
    ],

    'messages' => [
        'no_further_transitions' => 'Больше нет доступных переходов статуса.',
        'system' => 'Система',
    ],
];
