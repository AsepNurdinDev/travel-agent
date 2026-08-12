<x-app-layout title="Destinations">
    <section class="border-b border-slate-100 bg-white py-12">
        <div class="container-page">
            <p class="section-eyebrow">Explore</p>
            <h1 class="section-title">Destinations</h1>
            <p class="mt-3 max-w-xl text-muted">From volcanic highlands to coral reefs — find the region that fits your next trip.</p>

            <form action="{{ route('destinations.index') }}" method="GET" class="mt-6 max-w-md">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search destinations..." class="input pl-10">
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/></svg>
                </div>
            </form>
        </div>
    </section>

    <section class="container-page py-12">
        @if ($destinations->isEmpty())
            <x-empty-state title="No destinations found" description="Try a different search term." />
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($destinations as $destination)
                    <x-destination-card :destination="$destination" />
                @endforeach
            </div>
            <div class="mt-10">{{ $destinations->links() }}</div>
        @endif
    </section>
</x-app-layout>
