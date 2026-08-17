<x-app-layout :title="$tourPackage->name" :meta-description="$tourPackage->meta_description ?? $tourPackage->description">
    @php
        $images = $tourPackage->images->isNotEmpty() ? $tourPackage->images : collect();
        $coverImage = $tourPackage->cover_image ? asset('storage/'.$tourPackage->cover_image) : 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=1200&q=70';
    @endphp

    {{-- Gallery --}}
    <section class="bg-ink" x-data="{ active: 0, images: [{{ collect([$coverImage])->merge($images->map(fn($i) => $i->image ? asset('storage/'.$i->image) : $coverImage))->map(fn($u) => "'".$u."'")->implode(',') }}] }">
        <div class="container-page py-4">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 h-[420px]">
                <div class="sm:col-span-3 h-full overflow-hidden rounded-xl bg-slate-800">
                    <template x-for="(img, i) in images" :key="i">
                        <img x-show="active === i" :src="img" class="h-full w-full object-cover" alt="{{ $tourPackage->name }}">
                    </template>
                </div>
                <div class="hidden sm:grid grid-rows-4 gap-2 h-full">
                    <template x-for="(img, i) in images.slice(0,4)" :key="i">
                        <button @click="active = i" class="overflow-hidden rounded-lg ring-2" :class="active === i ? 'ring-accent' : 'ring-transparent'">
                            <img :src="img" class="h-full w-full object-cover" alt="">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <section class="container-page py-10 grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 min-w-0">
            <p class="text-sm font-semibold uppercase tracking-wide text-primary">
                <a href="{{ route('destinations.show', $tourPackage->destination->slug) }}" class="hover:underline">{{ $tourPackage->destination->name }}</a>
            </p>
            <h1 class="mt-1 text-3xl font-bold text-ink">{{ $tourPackage->name }}</h1>

            <div class="mt-3 flex flex-wrap items-center gap-4 text-sm text-muted">
                @if ($tourPackage->reviews_avg_rating)
                    <x-rating :value="$tourPackage->reviews_avg_rating" :count="$tourPackage->reviews_count" size="lg" />
                @endif
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $tourPackage->duration_days }} Days / {{ $tourPackage->duration_nights }} Nights
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-3.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4"/></svg>
                    {{ $tourPackage->min_participants }}–{{ $tourPackage->max_participants }} participants
                </span>
            </div>

            <div class="mt-6 prose prose-slate max-w-none text-muted">
                <p class="leading-relaxed whitespace-pre-line">{{ $tourPackage->description }}</p>
            </div>

            {{-- Itinerary --}}
            @if ($tourPackage->itineraries->isNotEmpty())
                <div class="mt-10" x-data="{ openDay: 1 }">
                    <h2 class="text-xl font-bold text-ink">Itinerary</h2>
                    <div class="mt-4 space-y-3">
                        @foreach ($tourPackage->itineraries as $day)
                            <div class="card overflow-hidden">
                                <button @click="openDay = openDay === {{ $day->day_number }} ? null : {{ $day->day_number }}"
                                        class="flex w-full items-center justify-between px-5 py-4 text-left">
                                    <span class="font-semibold text-ink">Day {{ $day->day_number }} — {{ $day->title }}</span>
                                    <svg class="h-5 w-5 text-muted transition" :class="openDay === {{ $day->day_number }} ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div x-show="openDay === {{ $day->day_number }}" x-transition x-cloak class="px-5 pb-4 text-sm text-muted leading-relaxed">
                                    {{ $day->description }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Inclusions / Exclusions --}}
            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-8">
                @if ($tourPackage->inclusions->isNotEmpty())
                    <div>
                        <h3 class="font-bold text-ink">What's Included</h3>
                        <ul class="mt-3 space-y-2">
                            @foreach ($tourPackage->inclusions as $item)
                                <li class="flex items-start gap-2 text-sm text-muted">
                                    <svg class="h-5 w-5 shrink-0 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    {{ $item->description }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if ($tourPackage->exclusions->isNotEmpty())
                    <div>
                        <h3 class="font-bold text-ink">Not Included</h3>
                        <ul class="mt-3 space-y-2">
                            @foreach ($tourPackage->exclusions as $item)
                                <li class="flex items-start gap-2 text-sm text-muted">
                                    <svg class="h-5 w-5 shrink-0 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    {{ $item->description }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- Add-ons preview --}}
            @if ($tourPackage->addons->isNotEmpty())
                <div class="mt-10">
                    <h3 class="font-bold text-ink">Available Add-ons</h3>
                    <p class="text-sm text-muted">Select these during booking to customize your trip.</p>
                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($tourPackage->addons as $addon)
                            <div class="card flex items-center justify-between px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-ink">{{ $addon->name }}</p>
                                    @if ($addon->description)
                                        <p class="text-xs text-muted">{{ $addon->description }}</p>
                                    @endif
                                </div>
                                <span class="text-sm font-semibold text-primary shrink-0 ml-3">Rp {{ number_format($addon->price, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Reviews --}}
            <div class="mt-10">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-ink">Reviews {{ $tourPackage->reviews_count ? "($tourPackage->reviews_count)" : '' }}</h3>
                    @if ($tourPackage->reviews_avg_rating)
                        <x-rating :value="$tourPackage->reviews_avg_rating" size="lg" />
                    @endif
                </div>
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @forelse ($tourPackage->reviews as $review)
                        <x-review-card :review="$review" />
                    @empty
                        <p class="text-sm text-muted sm:col-span-2">No reviews yet — be the first to travel and share your experience.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Booking sidebar --}}
        <div class="lg:col-span-1" id="departures">
            <div class="card sticky top-24 p-6">
                <p class="text-xs text-muted">Starting from</p>
                <p class="text-2xl font-bold text-ink">Rp {{ number_format($tourPackage->price_adult, 0, ',', '.') }} <span class="text-sm font-normal text-muted">/ adult</span></p>

                <div class="mt-2 text-xs text-muted space-y-0.5">
                    <p>Child: Rp {{ number_format($tourPackage->price_child, 0, ',', '.') }}</p>
                    <p>Infant: Rp {{ number_format($tourPackage->price_infant, 0, ',', '.') }}</p>
                </div>

                <h4 class="mt-5 text-sm font-semibold text-ink">Choose a departure date</h4>
                <div class="mt-3 space-y-2 max-h-72 overflow-y-auto pr-1">
                    @forelse ($tourPackage->availabilities as $availability)
                        <div class="flex items-center justify-between rounded-lg border border-slate-200 px-3 py-2.5 text-sm">
                            <div>
                                <p class="font-medium text-ink">{{ $availability->departure_date->format('d M Y') }}</p>
                                <p class="text-xs text-muted">{{ $availability->remaining_quota }} seats left</p>
                            </div>
                            @auth
                                <a href="{{ route('booking.create', $availability) }}" class="btn-primary !py-1.5 !px-3 text-xs">Book</a>
                            @else
                                <a href="{{ route('login') }}" class="btn-outline !py-1.5 !px-3 text-xs">Log in to book</a>
                            @endauth
                        </div>
                    @empty
                        <p class="text-sm text-muted">No upcoming departures right now — check back soon.</p>
                    @endforelse
                </div>

                <p class="mt-4 text-xs text-muted text-center">You won't be charged yet — pricing is confirmed at the next step.</p>
            </div>
        </div>
    </section>

    @if ($relatedTours->isNotEmpty())
    <section class="bg-white border-t border-slate-100 py-12">
        <div class="container-page">
            <h2 class="section-title !text-2xl">More tours in {{ $tourPackage->destination->name }}</h2>
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($relatedTours as $tour)
                    <x-tour-card :tour="$tour" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Extra clearance on mobile so the sticky CTA + bottom nav never cover content --}}
    <div class="h-28 lg:hidden" aria-hidden="true"></div>

    {{-- Sticky mobile booking CTA — sits just above the bottom tab bar --}}
    <div class="fixed inset-x-0 z-20 border-t border-slate-100 bg-white/95 px-4 py-3 backdrop-blur lg:hidden"
         style="bottom: calc(4rem + env(safe-area-inset-bottom));">
        <div class="flex items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="text-[11px] text-muted">From</p>
                <p class="truncate text-base font-bold text-ink">Rp {{ number_format($tourPackage->price_adult, 0, ',', '.') }} <span class="text-xs font-normal text-muted">/ adult</span></p>
            </div>
            <a href="#departures" class="btn-primary shrink-0">Book this trip</a>
        </div>
    </div>
</x-app-layout>
