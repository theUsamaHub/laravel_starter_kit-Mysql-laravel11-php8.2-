@props(['class' => ''])

<span {{ $attributes->merge(['class' => 'fw-bold text-primary fs-4']) }} style="font-family: 'Figtree', sans-serif;">
    {{ config('app.name', 'LSK') }}
</span>
