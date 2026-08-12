@props(['status'])
@php
    $map = [
        'pending' => 'bg-amber-100 text-amber-700',
        'confirmed' => 'bg-primary-100 text-primary-800',
        'completed' => 'bg-emerald-100 text-emerald-700',
        'cancelled' => 'bg-red-100 text-red-700',
        'open' => 'bg-emerald-100 text-emerald-700',
        'full' => 'bg-amber-100 text-amber-700',
        'closed' => 'bg-slate-200 text-slate-600',
        'paid' => 'bg-emerald-100 text-emerald-700',
        'partially_paid' => 'bg-amber-100 text-amber-700',
        'unpaid' => 'bg-red-100 text-red-700',
        'failed' => 'bg-red-100 text-red-700',
        'expired' => 'bg-slate-200 text-slate-600',
        'refunded' => 'bg-slate-200 text-slate-600',
    ];
    $classes = $map[$status] ?? 'bg-slate-100 text-slate-600';
@endphp
<span {{ $attributes->merge(['class' => "badge $classes"]) }}>
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
