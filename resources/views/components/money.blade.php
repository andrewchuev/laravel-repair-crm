@props(['amount'])

<span {{ $attributes->merge(['class' => 'font-medium text-slate-900']) }}>
    {{ number_format((float) $amount, 2, '.', ' ') }}
</span>
