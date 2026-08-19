<x-app-layout title="Profil Saya">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        
        {{-- Header Banner & Avatar Section --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-700 p-6 sm:p-8 text-white shadow-lg shadow-emerald-500/10">
            <!-- Decorative Background Patterns -->
            <div class="absolute -right-10 -bottom-10 h-48 w-48 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
            <div class="absolute right-1/3 -top-10 h-32 w-32 rounded-full bg-emerald-400/20 blur-xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col sm:flex-row items-center gap-5 text-center sm:text-left">
                <!-- Avatar Circle -->
                <div class="relative group">
                    <div class="h-20 w-20 sm:h-24 sm:w-24 rounded-2xl bg-white/10 backdrop-blur-md border-2 border-white/30 flex items-center justify-center text-2xl sm:text-3xl font-black text-white shadow-inner uppercase">
                        {{ substr(old('name', $customer->name ?? auth()->user()->name), 0, 2) }}
                    </div>
                    <div class="absolute -bottom-1 -right-1 h-6 w-6 rounded-full bg-emerald-400 border-2 border-emerald-700 flex items-center justify-center text-emerald-950" title="Verifikasi Aktif">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>

                <!-- User Info Header -->
                <div class="space-y-1">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-emerald-100 backdrop-blur-md border border-white/10">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                        Akun Terverifikasi
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                        {{ old('name', $customer->name ?? auth()->user()->name) }}
                    </h1>
                    <p class="text-xs sm:text-sm text-emerald-100/80 font-medium">
                        Kelola informasi pribadi untuk kemudahan transaksi & dokumen perjalanan Anda.
                    </p>
                </div>
            </div>
        </div>

        {{-- Flash Success Alert --}}
        @if (session('success'))
            <div class="flex items-center gap-3 rounded-2xl bg-emerald-50 border border-emerald-200/80 p-4 text-xs sm:text-sm text-emerald-800 shadow-sm transition-all animate-in fade-in slide-in-from-top-2">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-emerald-500 text-white shadow-sm">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold">Berhasil Disimpan!</p>
                    <p class="text-xs text-emerald-700/90">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Main Form --}}
        <form method="POST" action="{{ route('account.profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Section 1: Informasi Kontak -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-8 shadow-sm hover:shadow-md transition-shadow duration-200 space-y-5">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900">Kontak & Identitas Utama</h2>
                        <p class="text-xs text-slate-500">Informasi yang terhubung langsung dengan akun Anda.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Nama Lengkap --}}
                    <div class="space-y-1.5 sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name', $customer->name ?? auth()->user()->name) }}" 
                                   required 
                                   maxlength="255" 
                                   placeholder="Masukkan nama lengkap"
                                   class="w-full rounded-xl border border-slate-200 bg-white pl-10 pr-4 py-2.5 text-xs sm:text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    {{-- Email (Read-Only) --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" 
                                   value="{{ auth()->user()->email }}" 
                                   disabled 
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50/80 pl-10 pr-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-500 cursor-not-allowed">
                        </div>
                        <p class="text-[11px] text-slate-400">
                            Ubah email di <a href="{{ route('profile.edit') }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline">Pengaturan Akun</a>.
                        </p>
                    </div>

                    {{-- Nomor Telepon --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">No. Telepon / WhatsApp</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <input type="text" 
                                   name="phone" 
                                   value="{{ old('phone', $customer->phone ?? '') }}" 
                                   required 
                                   maxlength="20" 
                                   placeholder="Contoh: 081234567890"
                                   class="w-full rounded-xl border border-slate-200 bg-white pl-10 pr-4 py-2.5 text-xs sm:text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition">
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                    </div>
                </div>
            </div>

            <!-- Section 2: Data Verifikasi & Alamat -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-8 shadow-sm hover:shadow-md transition-shadow duration-200 space-y-5">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="p-2.5 rounded-xl bg-teal-50 text-teal-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-6 0h6" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900">Dokumen & Alamat</h2>
                        <p class="text-xs text-slate-500">Diperlukan untuk validasi pemesanan tiket / layanan.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    {{-- Identity Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        {{-- No. KTP / Paspor --}}
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">No. KTP / Paspor</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3m-3 3h3m-3 3h3M4 6h16a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z" />
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="identity_number" 
                                       value="{{ old('identity_number', $customer->identity_number ?? '') }}" 
                                       maxlength="50" 
                                       placeholder="16 digit NIK / Nomor Paspor"
                                       class="w-full rounded-xl border border-slate-200 bg-white pl-10 pr-4 py-2.5 text-xs sm:text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition">
                            </div>
                            <x-input-error :messages="$errors->get('identity_number')" class="mt-1" />
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Tanggal Lahir</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" 
                                       name="date_of_birth" 
                                       value="{{ old('date_of_birth', optional($customer->date_of_birth ?? null)->format('Y-m-d')) }}" 
                                       class="w-full rounded-xl border border-slate-200 bg-white pl-10 pr-4 py-2.5 text-xs sm:text-sm font-medium text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition">
                            </div>
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1" />
                        </div>
                    </div>

                    {{-- Alamat Lengkap --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Alamat Lengkap Domisili</label>
                        <div class="relative">
                            <div class="absolute top-3 left-3.5 flex items-start pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <textarea name="address" 
                                      rows="3" 
                                      maxlength="500" 
                                      placeholder="Tuliskan jalan, nomor rumah, RT/RW, kecamatan, dan kota..."
                                      class="w-full rounded-xl border border-slate-200 bg-white pl-10 pr-4 py-2.5 text-xs sm:text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition resize-none">{{ old('address', $customer->address ?? '') }}</textarea>
                        </div>
                        <x-input-error :messages="$errors->get('address')" class="mt-1" />
                    </div>
                </div>
            </div>

            {{-- Submit Action Bar --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="submit" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 px-8 py-3.5 text-xs sm:text-sm font-extrabold text-white shadow-lg shadow-emerald-600/25 hover:from-emerald-700 hover:to-teal-700 active:scale-[0.98] transition-all duration-150">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>

    </div>
</x-app-layout>