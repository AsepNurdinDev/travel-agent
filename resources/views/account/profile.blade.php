<x-app-layout title="Profil Saya">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        
        {{-- Flash Success Alert --}}
        @if (session('success'))
            <div class="flex items-center gap-3 rounded-2xl bg-emerald-50 border border-emerald-200/80 p-4 text-xs sm:text-sm text-emerald-800 shadow-sm">
                <svg class="h-5 w-5 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Main Form Card --}}
        <div class="rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-sm space-y-6">
            
            {{-- Header Section --}}
            <div class="border-b border-slate-100 pb-5">
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Informasi Pribadi</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Data ini digunakan untuk verifikasi pemesanan dan dokumen perjalanan Anda.</p>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('account.profile.update') }}" class="space-y-5">
                @csrf
                @method('PATCH')

                {{-- Nama Lengkap --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Nama Lengkap</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $customer->name ?? auth()->user()->name) }}" 
                           required 
                           maxlength="255" 
                           placeholder="Masukkan nama lengkap Anda"
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs sm:text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                {{-- Email (Read-Only) --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Alamat Email</label>
                    <input type="email" 
                           value="{{ auth()->user()->email }}" 
                           disabled 
                           class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-500 cursor-not-allowed">
                    <p class="text-[11px] text-slate-400 font-medium">
                        Ingin mengubah email? Silakan buka <a href="{{ route('profile.edit') }}" class="font-bold text-emerald-600 hover:underline">Pengaturan Akun</a>.
                    </p>
                </div>

                {{-- Nomor Telepon --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Nomor Telepon / WhatsApp</label>
                    <input type="text" 
                           name="phone" 
                           value="{{ old('phone', $customer->phone ?? '') }}" 
                           required 
                           maxlength="20" 
                           placeholder="Contoh: 081234567890"
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs sm:text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                    <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                </div>

                {{-- Alamat --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Alamat Lengkap</label>
                    <textarea name="address" 
                              rows="3" 
                              maxlength="500" 
                              placeholder="Masukkan alamat rumah atau domisili Anda"
                              class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs sm:text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition resize-none">{{ old('address', $customer->address ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-1" />
                </div>

                {{-- Identity Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- No. KTP / Paspor --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">No. KTP / Paspor</label>
                        <input type="text" 
                               name="identity_number" 
                               value="{{ old('identity_number', $customer->identity_number ?? '') }}" 
                               maxlength="50" 
                               placeholder="16 digit NIK atau Nomor Paspor"
                               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs sm:text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                        <x-input-error :messages="$errors->get('identity_number')" class="mt-1" />
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Tanggal Lahir</label>
                        <input type="date" 
                               name="date_of_birth" 
                               value="{{ old('date_of_birth', optional($customer->date_of_birth ?? null)->format('Y-m-d')) }}" 
                               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs sm:text-sm font-medium text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                        <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1" />
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-xs font-bold text-white shadow-sm hover:bg-emerald-700 active:scale-[0.99] transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>

        </div>

    </div>
</x-app-layout>