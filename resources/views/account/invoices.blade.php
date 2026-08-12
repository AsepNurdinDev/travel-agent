<x-app-layout title="Invoices">
    @if ($invoices->isEmpty())
        <x-empty-state title="No invoices yet" description="Invoices are created automatically when you make a booking." />
    @else
        <div class="space-y-3">
            @foreach ($invoices as $invoice)
                <x-invoice-card :invoice="$invoice" />
            @endforeach
        </div>
        <div class="mt-8">{{ $invoices->links() }}</div>
    @endif
</x-app-layout>
