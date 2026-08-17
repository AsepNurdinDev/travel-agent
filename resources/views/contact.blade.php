<x-app-layout title="Kontak Us">
    <section class="border-b border-slate-100 bg-white py-10">
        <div class="container-page">
            <p class="section-eyebrow">We'd love to hear from you</p>
            <h1 class="section-title !text-3xl">Kontak Us</h1>
        </div>
    </section>

    <section class="container-page py-14 grid grid-cols-1 lg:grid-cols-5 gap-10">
        <div class="lg:col-span-2 space-y-6">
            @foreach ([
                ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'title' => 'Office', 'value' => \App\Models\Setting::getValue('contact_address', 'Jl. Merdeka No. 1, Bandung, Indonesia')],
                ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'title' => 'Phone', 'value' => \App\Models\Setting::getValue('contact_phone', '+62 21 555 0123')],
                ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'title' => 'Email', 'value' => \App\Models\Setting::getValue('contact_email', 'hello@nusantarajourneys.test')],
            ] as $item)
                <div class="flex items-start gap-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary-50 text-primary">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                    </span>
                    <div>
                        <p class="font-semibold text-ink">{{ $item['title'] }}</p>
                        <p class="text-sm text-muted">{{ $item['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="lg:col-span-3">
            <div class="card p-6 sm:p-8">
                <form method="POST" action="{{ route('contact.store') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <label class="label">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" required maxlength="255" class="input">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>
                    <div>
                        <label class="label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required maxlength="255" class="input">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>
                    <div>
                        <label class="label">Phone <span class="text-muted font-normal">(optional)</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" maxlength="20" class="input">
                        <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                    </div>
                    <div>
                        <label class="label">Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required maxlength="255" class="input">
                        <x-input-error :messages="$errors->get('subject')" class="mt-1" />
                    </div>
                    <div class="sm:col-span-2">
                        <label class="label">Message</label>
                        <textarea name="message" rows="5" required maxlength="2000" class="input">{{ old('message') }}</textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-1" />
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="btn-primary">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
