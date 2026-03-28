<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Акт виконаних робіт {{ data_get($document, 'number') }}</title>
    @include('documents.partials.style')
</head>
<body>
<div class="page">
    <div class="title">Акт виконаних робіт</div>
    <div class="muted">№ {{ data_get($document, 'number') }} від {{ data_get($document, 'date') }}</div>

    <table class="two-col section">
        <tr>
            <td>
                <div class="label">Виконавець</div>
                <div class="value">{{ data_get($document, 'snapshot.business_profile.legal_name') }}</div>
                <div class="value">РНОКПП: {{ data_get($document, 'snapshot.business_profile.tax_id') }}</div>
            </td>
            <td>
                <div class="label">Замовник</div>
                <div class="value">{{ data_get($document, 'snapshot.client.name') }}</div>
                <div class="value">{{ data_get($document, 'snapshot.client.phone') }}</div>
                <div class="value">{{ data_get($document, 'snapshot.client.email') }}</div>
            </td>
        </tr>
    </table>

    <div class="section">
        <div class="label">Замовлення</div>
        <div class="value">{{ data_get($document, 'snapshot.service_order.order_number') }}</div>
        <div class="value">{{ data_get($document, 'snapshot.service_order.item_name') }}</div>
    </div>

    <table class="grid section">
        <thead>
        <tr>
            <th style="width: 50px;">№</th>
            <th>Найменування</th>
            <th style="width: 90px;">Кіл-ть</th>
            <th style="width: 120px;">Ціна</th>
            <th style="width: 120px;">Сума</th>
        </tr>
        </thead>
        <tbody>
        @foreach (data_get($document, 'snapshot.items', []) as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ data_get($item, 'name') }}</td>
                <td>{{ number_format((float) data_get($item, 'quantity', 0), 2, '.', ' ') }}</td>
                <td>{{ number_format((float) data_get($item, 'unit_price', 0), 2, '.', ' ') }}</td>
                <td>{{ number_format((float) data_get($item, 'total_price', 0), 2, '.', ' ') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="section" style="text-align: right;">
        <div><strong>Всього: {{ number_format((float) data_get($document, 'snapshot.totals.final_price', 0), 2, '.', ' ') }} грн</strong></div>
        <div>Сплачено: {{ number_format((float) data_get($document, 'snapshot.totals.paid_amount', 0), 2, '.', ' ') }} грн</div>
        <div>Залишок: {{ number_format((float) data_get($document, 'snapshot.totals.balance_amount', 0), 2, '.', ' ') }} грн</div>
    </div>

    <div class="footer">
        Замовник підтверджує належне виконання робіт та відсутність претензій до якості виконаних робіт на момент підписання цього акта.
    </div>

    <table class="signatures">
        <tr>
            <td>Підпис виконавця: ____________________</td>
            <td>Підпис замовника: ____________________</td>
        </tr>
    </table>
</div>
</body>
</html>
