<?php

return [
    'title' => 'Service Orders',

    'index' => [
        'title' => 'Service Orders',
        'subtitle' => 'Track active, ready, and completed work.',
        'search_placeholder' => 'Search by number, client, phone, serial...',
        'all_statuses' => 'All statuses',
        'all_categories' => 'All categories',
        'create_button' => 'Create order',
    ],

    'create' => [
        'title' => 'Create Service Order',
        'subtitle' => 'Register a new device intake and create a repair order.',
        'select_client' => 'Select client',
        'create_button' => 'Create order',
    ],

    'show' => [
        'title' => 'Service Order',
        'subtitle' => 'Interactive service order detail page with core sections.',
        'documents_button' => 'Documents',
    ],

    'fields' => [
        'order_number' => 'Order',
        'client' => 'Client',
        'priority' => 'Priority',
        'category' => 'Category',
        'item_name' => 'Item',
        'brand' => 'Brand',
        'model' => 'Model',
        'serial_number' => 'Serial number',
        'reported_problem' => 'Reported problem',
        'intake_condition' => 'Intake condition',
        'accessories' => 'Accessories',
        'diagnostic_summary' => 'Diagnostic summary',
        'work_result' => 'Work result',
        'internal_notes' => 'Internal notes',
        'customer_notes' => 'Customer notes',
        'estimated_price' => 'Estimated price',
        'agreed_price' => 'Agreed price',
        'final_price' => 'Final',
        'paid_amount' => 'Paid',
        'balance_amount' => 'Balance',
        'received_at' => 'Received',
        'promised_at' => 'Promised at',
        'approved_at' => 'Approved at',
        'ready_at' => 'Ready at',
        'delivered_at' => 'Delivered at',
        'warranty_until' => 'Warranty until',
        'accepted_by' => 'Accepted by',
        'assigned_master' => 'Master',
        'position' => 'Position',
        'quantity' => 'Qty',
        'unit_price' => 'Unit price',
        'cost_price' => 'Cost price',
        'total_price' => 'Total',
        'visibility' => 'Visibility',
        'body' => 'Comment',
    ],

    'sections' => [
        'client' => 'Client',
        'device_problem' => 'Device & problem',
        'status' => 'Status',
        'comments' => 'Comments',
        'attachments' => 'Attachments',
        'works_parts' => 'Works & Parts',
        'payments' => 'Payments',
        'status_history' => 'Status history',
        'add_comment' => 'Add comment',
        'add_item' => 'Add item',
        'record_payment' => 'Record payment',
        'upload_attachment' => 'Upload attachment',
    ],

    'actions' => [
        'update_status' => 'Update status',
        'save_payment' => 'Save payment',
    ],

    'generic' => [
        'current' => 'Current',
        'next_status' => 'Next status',
        'select_status' => 'Select status',
        'name' => 'Name',
        'description' => 'Description',
        'unit_short' => 'Unit',
    ],

    'empty' => [
        'orders_title' => 'No service orders yet.',
        'orders_description' => 'Create the first service order to start tracking workshop work.',
        'items_title' => 'No items yet.',
        'items_description' => 'Add work or part line items below.',
        'comments_title' => 'No comments yet.',
        'comments_description' => 'Add internal or public notes below.',
        'payments_title' => 'No payments yet.',
        'payments_description' => 'Record the first payment below.',
        'history_title' => 'No status history yet.',
        'history_description' => 'Status changes will appear here.',
    ],

    'counts' => [
        'events' => ':count event(s)',
    ],

    'confirm_delete_item' => 'Delete this item?',

    'status' => [
        'new' => 'New',
        'diagnostics' => 'Diagnostics',
        'awaiting_approval' => 'Awaiting approval',
        'approved' => 'Approved',
        'in_progress' => 'In progress',
        'waiting_parts' => 'Waiting parts',
        'ready' => 'Ready',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled',
    ],

    'priority' => [
        'low' => 'Low',
        'normal' => 'Normal',
        'high' => 'High',
        'urgent' => 'Urgent',
    ],

    'category' => [
        'computer' => 'Computer',
        'desktop' => 'Desktop PC',
        'laptop' => 'Laptop',
        'printer' => 'Printer',
        'mfp' => 'MFP',
        'tablet' => 'Tablet',
        'monitor' => 'Monitor',
        'network' => 'Network equipment',
        'networking' => 'Networking equipment',
        'cartridge' => 'Cartridge',
        'server' => 'Server',
        'other' => 'Other',
    ],

    'item_type' => [
        'work' => 'Work',
        'part' => 'Part',
        'service' => 'Service',
        'discount' => 'Discount',
    ],

    'comment_visibility' => [
        'internal' => 'Internal',
        'public' => 'Public',
        'customer' => 'Customer',
    ],

    'device_editor' => [
        'actions' => [
            'edit' => 'Edit',
            'save' => 'Save changes',
            'cancel' => 'Cancel',
        ],
        'messages' => [
            'saved' => 'Device and problem details updated successfully.',
            'locked' => 'This section can no longer be edited.',
            'read_only' => 'This order is read-only in the current status for your role.',
        ],
    ],

    'messages' => [
        'no_further_transitions' => 'No further transitions available.',
        'system' => 'System',
    ],
];
