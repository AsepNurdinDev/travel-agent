<x-app-layout title="Tentang Kami">
    <section class="relative overflow-hidden bg-ink py-24">
        <img src="https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?w=1600&q=70" class="absolute inset-0 h-full w-full object-cover opacity-40" alt="">
        <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/60 to-ink/30"></div>
        <div class="container-page relative z-10 text-center">
            <p class="section-eyebrow text-primary-200">Our Story</p>
            <h1 class="mt-2 text-4xl font-bold text-white">Built by orang, for orang</h1>
            <p class="mt-3 max-w-xl mx-auto text-slate-200">{{ \App\Models\Setting::getValue('site_tagline', 'A team of local guides and planners bringing you honest, well-run trips across Indonesia.') }}</p>
        </div>
    </section>

    <section class="container-page py-16 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <p class="section-eyebrow">Our Journey</p>
            <h2 class="section-title !text-3xl">From a small crew to a nationwide network</h2>
            <p class="mt-4 text-muted leading-relaxed">
                {{ \App\Models\Setting::getValue('about_story', "What started as a handful of friends guiding trips around their home island has grown into a full-service travel agency covering dozens of destinations. We still run every tour the same way we did on day one — with care, transparency, and a genuine love for the places we visit.") }}
            </p>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <img src="https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=500&q=65" class="rounded-2xl h-56 w-full object-cover" alt="">
            <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=500&q=65" class="rounded-2xl h-56 w-full object-cover mt-8" alt="">
        </div>
    </section>

    <section class="bg-white border-y border-slate-100 py-16">
        <div class="container-page grid grid-cols-1 sm:grid-cols-2 gap-8">
            <div class="card p-6">
                <h3 class="font-bold text-ink">Our Mission</h3>
                <p class="mt-2 text-sm text-muted leading-relaxed">
                    {{ \App\Models\Setting::getValue('about_mission', 'To make thoughtfully planned travel across Indonesia accessible, transparent, and dependable — from the first click to the last day of your trip.') }}
                </p>
            </div>
            <div class="card p-6">
                <h3 class="font-bold text-ink">Our Vision</h3>
                <p class="mt-2 text-sm text-muted leading-relaxed">
                    {{ \App\Models\Setting::getValue('about_vision', 'To be the most trusted travel partner for exploring Indonesia\'s islands, culture, and nature — one well-run trip at a time.') }}
                </p>
            </div>
        </div>
    </section>

    <section class="container-page py-16">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
            @foreach ([
                ['value' => $stats['destinations'], 'label' => 'Destinasi'],
                ['value' => $stats['tours'], 'label' => 'Paket Wisata'],
                ['value' => $stats['orang'], 'label' => 'Happy Travelers'],
                ['value' => $stats['avg_rating'] ?: '5.0', 'label' => 'Average Rating'],
            ] as $s)
                <div>
                    <p class="text-3xl font-bold text-primary">{{ $s['value'] }}+</p>
                    <p class="mt-1 text-sm text-muted">{{ $s['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="container-page pb-16">
        <div class="rounded-3xl bg-primary px-8 py-14 text-center sm:px-16">
            <h2 class="text-3xl font-bold text-white">Let's plan your next trip</h2>
            <p class="mt-3 text-primary-100">Browse our tours or reach out — our team is happy to help you find the right fit.</p>
            <div class="mt-7 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('tours.index') }}" class="btn-accent">Browse Paket Wisata</a>
                <a href="{{ route('contact.index') }}" class="btn bg-white text-primary hover:bg-primary-50">Kontak Us</a>
            </div>
        </div>
    </section>
</x-app-layout>
