<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Акт приймання {{ data_get($document, 'number') }}</title>
    @include('documents.partials.style')
</head>
<body>
<div class="page">
    <div class="title">Акт приймання-передачі в ремонт</div>
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
        <div class="label">Прийнятий пристрій</div>
        <div class="value">{{ data_get($document, 'snapshot.service_order.item_name') }}</div>
        <div class="value">Бренд/модель: {{ data_get($document, 'snapshot.service_order.brand') }} {{ data_get($document, 'snapshot.service_order.model') }}</div>
        <div class="value">Серійний номер: {{ data_get($document, 'snapshot.service_order.serial_number') ?: '—' }}</div>
    </div>

    <div class="section">
        <div class="label">Заявлена несправність</div>
        <div class="value">{{ data_get($document, 'snapshot.service_order.reported_problem') }}</div>
    </div>

    <div class="section">
        <div class="label">Стан при прийманні</div>
        <div class="value">{{ data_get($document, 'snapshot.service_order.intake_condition') ?: '—' }}</div>
    </div>

    <div class="section">
        <div class="label">Комплектність</div>
        <div class="value">{{ data_get($document, 'snapshot.service_order.accessories') ?: '—' }}</div>
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
