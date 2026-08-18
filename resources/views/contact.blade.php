<x-app-layout title="Hubungi Kami">
    {{-- Header Section --}}
    <section class="border-b border-slate-200/60 bg-gradient-to-b from-slate-50 to-white py-12 sm:py-16">
        <div class="container-page">
            <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Layanan Pelanggan</span>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 mt-2 tracking-tight">Hubungi Kami</h1>
            <p class="mt-3 text-base sm:text-lg text-slate-600 max-w-2xl font-light">
                Ada pertanyaan mengenai paket wisata, pemesanan, atau butuh bantuan khusus? Kami siap membantu Anda.
            </p>
        </div>
    </section>

    {{-- Main Content Section --}}
    <section class="container-page py-12 sm:py-16 grid grid-cols-1 lg:grid-cols-5 gap-10">
        
        {{-- Contact Info Cards --}}
        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Informasi Kontak</h2>

            @foreach ([
                ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'title' => 'Kantor Utama', 'value' => \App\Models\Setting::getValue('contact_address', 'Jl. Merdeka No. 1, Bandung, Indonesia')],
                ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'title' => 'Nomor Telepon / WhatsApp', 'value' => \App\Models\Setting::getValue('contact_phone', '+62 21 555 0123')],
                ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'title' => 'Alamat Email', 'value' => \App\Models\Setting::getValue('contact_email', 'hello@nusantarajourneys.test')],
            ] as $item)
                <div class="flex items-start gap-4 p-5 rounded-2xl bg-white border border-slate-100 shadow-sm transition hover:shadow-md hover:border-slate-200">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                    </span>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ $item['title'] }}</p>
                        <p class="text-sm font-semibold text-slate-800 mt-1 leading-relaxed">{{ $item['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Contact Form --}}
        <div class="lg:col-span-3">
            <div class="rounded-3xl bg-white p-6 sm:p-10 border border-slate-100 shadow-xl shadow-slate-100">
                <h2 class="text-xl font-bold text-slate-900 mb-2">Kirim Pesan</h2>
                <p class="text-sm text-slate-500 mb-6">Isi formulir di bawah ini dan tim kami akan segera menghubungi Anda kembali.</p>

                <form method="POST" action="{{ route('contact.store') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @csrf
                    
                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required maxlength="255" placeholder="Nama Anda"
                               class="block w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition duration-200">
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="255" placeholder="nama@email.com"
                               class="block w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition duration-200">
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>

                    {{-- Telepon --}}
                    <div>
                        <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Nomor Telepon <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                        </label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" maxlength="20" placeholder="081234567890"
                               class="block w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition duration-200">
                        <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
                    </div>

                    {{-- Subjek --}}
                    <div>
                        <label for="subject" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Subjek</label>
                        <input id="subject" type="text" name="subject" value="{{ old('subject') }}" required maxlength="255" placeholder="Subjek pesan"
                               class="block w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition duration-200">
                        <x-input-error :messages="$errors->get('subject')" class="mt-1.5" />
                    </div>

                    {{-- Pesan --}}
                    <div class="sm:col-span-2">
                        <label for="message" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Pesan Anda</label>
                        <textarea id="message" name="message" rows="5" required maxlength="2000" placeholder="Tuliskan pertanyaan atau kebutuhan Anda di sini..."
                                  class="block w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition duration-200">{{ old('message') }}</textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-1.5" />
                    </div>

                    {{-- Submit Button --}}
                    <div class="sm:col-span-2 pt-2">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 py-3.5 px-8 text-sm font-bold text-white shadow-lg shadow-emerald-500/25 hover:from-emerald-500 hover:to-teal-500 active:scale-[0.99] transition duration-200">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>