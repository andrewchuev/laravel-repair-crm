<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Рахунок {{ data_get($document, 'number') }}</title>
    @include('documents.partials.style')
</head>
<body>
<div class="page">
    <div class="title">Рахунок на оплату</div>
    <div class="muted">№ {{ data_get($document, 'number') }} від {{ data_get($document, 'date') }}</div>

    <table class="two-col section">
        <tr>
            <td>
                <div class="label">Виконавець</div>
                <div class="value">{{ data_get($document, 'snapshot.business_profile.legal_name') }}</div>
                <div class="value">РНОКПП: {{ data_get($document, 'snapshot.business_profile.tax_id') }}</div>
                <div class="value">{{ data_get($document, 'snapshot.business_profile.actual_address') ?: data_get($document, 'snapshot.business_profile.registration_address') }}</div>
                <div class="value">{{ data_get($document, 'snapshot.business_profile.phone') }}</div>
                <div class="value">{{ data_get($document, 'snapshot.business_profile.email') }}</div>
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
        <div class="label">Реквізити для оплати</div>
        <div class="value">Одержувач: {{ data_get($document, 'snapshot.bank_account.recipient') }}</div>
        <div class="value">IBAN: {{ data_get($document, 'snapshot.bank_account.iban') }}</div>
        <div class="value">Банк: {{ data_get($document, 'snapshot.bank_account.bank_name') }}</div>
        <div class="value">МФО: {{ data_get($document, 'snapshot.bank_account.bank_mfo') }}</div>
        <div class="value">ЄДРПОУ банку: {{ data_get($document, 'snapshot.bank_account.bank_edrpou') }}</div>
        <div class="value">Призначення платежу: {{ data_get($document, 'snapshot.bank_account.payment_purpose_template') }}</div>
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
        <strong>До сплати: {{ number_format((float) data_get($document, 'snapshot.totals.balance_amount', data_get($document, 'snapshot.totals.final_price', 0)), 2, '.', ' ') }} грн</strong>
    </div>
</div>
</body>
</html>
