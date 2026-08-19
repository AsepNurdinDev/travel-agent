<x-app-layout title="Pesan Perjalanan">
@php
    $addonsJson = $tourPackage->addons->map(fn($a) => [
        'id' => $a->id, 'name' => $a->name, 'price' => (float) $a->price, 'description' => $a->description,
    ])->values();
@endphp

<div
    x-data="bookingForm({
        availabilityId: {{ $availability->id }},
        remainingQuota: {{ $availability->remaining_quota }},
        addons: {{ $addonsJson->toJson() }},
        estimateUrl: '{{ route('booking.estimate') }}',
        csrf: '{{ csrf_token() }}',
    })"
    x-init="refreshEstimate(); {{ $errors->any() || session('error') ? 'step = ' . ($errors->has('name') || $errors->has('phone') || $errors->has('address') || $errors->has('identity_number') || $errors->has('date_of_birth') ? 3 : ($errors->has('adult_count') || $errors->has('child_count') || $errors->has('infant_count') ? 2 : 5)) . ';' : '' }}"
    class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
>
    {{-- Error banner: shown regardless of which step Alpine lands on after a
         failed submit, so a rejected booking is never silently invisible. --}}
    @if (session('error'))
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="font-bold mb-1">Pemesanan belum bisa diproses, mohon periksa kembali:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Stepper Progress --}}
    <div class="mb-10 overflow-x-auto pb-4 pt-1">
        <div class="flex items-center justify-between min-w-[600px] max-w-4xl mx-auto">
            <template x-for="(label, i) in steps" :key="i">
                <div class="flex items-center flex-1 last:flex-none">
                    <div class="flex items-center gap-3 cursor-pointer group" @click="if (i + 1 < step || completedSteps.includes(i+1)) step = i + 1">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-xs font-bold transition-all duration-200 shadow-sm"
                              :class="step === i + 1 
                                ? 'bg-emerald-600 text-white ring-4 ring-emerald-100' 
                                : (step > i + 1 || completedSteps.includes(i+1) ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-400 group-hover:bg-slate-200')"
                              x-text="i + 1"></span>
                        <span class="text-sm font-semibold transition-colors duration-200" 
                              :class="step === i + 1 ? 'text-slate-900 font-bold' : 'text-slate-500'" 
                              x-text="label"></span>
                    </div>
                    <div class="mx-4 h-0.5 flex-1 bg-slate-200 rounded" x-show="i < steps.length - 1"
                         :class="step > i + 1 ? 'bg-emerald-500' : 'bg-slate-200'"></div>
                </div>
            </template>
        </div>
    </div>

    <form @submit.prevent="submit" method="POST" :action="'{{ route('booking.store', $availability) }}'">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- Main Form Content Area --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Step 1: Trip Summary --}}
                <div x-show="step === 1" x-cloak class="rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-sm">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h2 class="text-xl font-bold text-slate-900">Detail Perjalanan</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Konfirmasi tanggal dan durasi tur pilihan Anda.</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-5 p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                        <img src="{{ $tourPackage->cover_image ? asset('storage/'.$tourPackage->cover_image) : 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=400&q=80' }}"
                             class="h-28 w-full sm:w-36 shrink-0 rounded-xl object-cover shadow-sm" alt="{{ $tourPackage->name }}">
                        <div class="flex flex-col justify-between">
                            <div>
                                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-600">{{ $tourPackage->destination->name }}</span>
                                <h3 class="text-base font-bold text-slate-900 mt-0.5">{{ $tourPackage->name }}</h3>
                                <p class="text-xs font-medium text-slate-500 mt-1">{{ $tourPackage->duration_days }} Hari / {{ $tourPackage->duration_nights }} Malam</p>
                            </div>
                            
                            <div class="mt-3 pt-3 border-t border-slate-200/60 flex flex-wrap items-center justify-between gap-2 text-xs">
                                <div class="text-slate-600">
                                    <span class="font-bold text-slate-900">{{ $availability->departure_date->format('d M Y') }}</span> 
                                    <span class="text-slate-400 mx-1">—</span> 
                                    <span class="font-bold text-slate-900">{{ $availability->return_date->format('d M Y') }}</span>
                                </div>
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700 border border-emerald-200/50">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    <span x-text="remainingQuota + ' sisa kuota'"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="button" @click="goNext()" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 transition">
                            Lanjutkan
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Step 2: Peserta --}}
                <div x-show="step === 2" x-cloak class="rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-sm">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h2 class="text-xl font-bold text-slate-900">Jumlah Peserta</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Tentukan jumlah orang yang akan ikut dalam perjalanan ini.</p>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach ([
                            ['key'=>'adult','label'=>'Dewasa','desc'=>'Usia 12 tahun ke atas'],
                            ['key'=>'child','label'=>'Anak-anak','desc'=>'Usia 2–11 tahun'],
                            ['key'=>'infant','label'=>'Bayi','desc'=>'Di bawah 2 tahun']
                        ] as $p)
                        <div class="flex items-center justify-between py-4 first:pt-0 last:pb-0">
                            <div>
                                <p class="text-sm font-bold text-slate-900">{{ $p['label'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $p['desc'] }}</p>
                            </div>
                            <div class="flex items-center gap-3 bg-slate-50 p-1.5 rounded-2xl border border-slate-200/60">
                                <button type="button" @click="dec('{{ $p['key'] }}')" class="flex h-8 w-8 items-center justify-center rounded-xl bg-white text-slate-700 shadow-sm border border-slate-200 hover:bg-slate-100 transition disabled:opacity-40" :disabled="counts.{{ $p['key'] }} <= ({{ $p['key'] === 'adult' ? 1 : 0 }})">−</button>
                                <span class="w-7 text-center font-bold text-sm text-slate-900" x-text="counts.{{ $p['key'] }}"></span>
                                <button type="button" @click="inc('{{ $p['key'] }}')" class="flex h-8 w-8 items-center justify-center rounded-xl bg-white text-slate-700 shadow-sm border border-slate-200 hover:bg-slate-100 transition">+</button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <input type="hidden" name="adult_count" :value="counts.adult">
                    <input type="hidden" name="child_count" :value="counts.child">
                    <input type="hidden" name="infant_count" :value="counts.infant">
                    
                    <p x-show="totalPeserta() > remainingQuota" x-cloak class="mt-4 rounded-xl bg-red-50 p-3 text-xs font-semibold text-red-600 border border-red-100 flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Tersisa <span x-text="remainingQuota"></span> kursi untuk tanggal keberangkatan ini.
                    </p>

                    <div class="mt-8 flex justify-between items-center">
                        <button type="button" @click="step = 1" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-200 transition">Kembali</button>
                        <button type="button" @click="goNext()" :disabled="totalPeserta() < 1 || totalPeserta() > remainingQuota" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 transition disabled:opacity-50">Lanjutkan</button>
                    </div>
                </div>

                {{-- Step 3: Customer Information --}}
                <div x-show="step === 3" x-cloak class="rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-sm">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h2 class="text-xl font-bold text-slate-900">Data Diri Pemesan</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Informasi ini digunakan untuk konfirmasi pesanan dan e-tiket.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" required maxlength="255" value="{{ old('name', $customer->name ?? auth()->user()->name) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email</label>
                            <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Telepon / WA</label>
                            <input type="text" name="phone" required maxlength="20" value="{{ old('phone', $customer->phone ?? '') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat <span class="text-slate-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="address" maxlength="500" value="{{ old('address', $customer->address ?? '') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor KTP / Paspor <span class="text-slate-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="identity_number" maxlength="50" value="{{ old('identity_number', $customer->identity_number ?? '') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Lahir <span class="text-slate-400 font-normal">(Opsional)</span></label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($customer->date_of_birth ?? null)->format('Y-m-d')) }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Catatan Khusus <span class="text-slate-400 font-normal">(Opsional)</span></label>
                            <textarea name="notes" rows="2" maxlength="1000" placeholder="Permintaan khusus seperti makanan, kasur tambahan, dll." class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-500 focus:ring-emerald-500">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <button type="button" @click="step = 2" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-200 transition">Kembali</button>
                        <button type="button" @click="goNext()" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 transition">Lanjutkan</button>
                    </div>
                </div>

                {{-- Step 4: Add-ons --}}
                <div x-show="step === 4" x-cloak class="rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-sm">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h2 class="text-xl font-bold text-slate-900">Layanan Tambahan</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Pilih fasilitas & perlengkapan ekstra untuk menyempurnakan tur Anda.</p>
                    </div>

                    <div class="space-y-3">
                        <template x-if="addons.length === 0">
                            <div class="rounded-2xl border border-dashed border-slate-200 p-6 text-center">
                                <p class="text-xs font-medium text-slate-400">Tidak ada layanan tambahan tersedia untuk paket ini.</p>
                            </div>
                        </template>
                        <template x-for="addon in addons" :key="addon.id">
                            <label class="flex items-center justify-between rounded-2xl border p-4 cursor-pointer transition-all duration-200"
                                   :class="selectedAddons[addon.id] ? 'border-emerald-500 bg-emerald-50/30 ring-1 ring-emerald-500/20' : 'border-slate-200/80 hover:border-slate-300'">
                                <div class="flex items-center gap-3.5">
                                    <input type="checkbox" :checked="!!selectedAddons[addon.id]" @change="toggleAddon(addon.id)" class="h-5 w-5 rounded-md text-emerald-600 focus:ring-emerald-500 border-slate-300">
                                    <div>
                                        <p class="text-sm font-bold text-slate-900" x-text="addon.name"></p>
                                        <p class="text-xs text-slate-500 mt-0.5" x-text="addon.description"></p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <template x-if="selectedAddons[addon.id]">
                                        <div class="flex items-center gap-2 bg-white p-1 rounded-xl border border-slate-200 shadow-sm">
                                            <button type="button" @click.prevent="changeQty(addon.id, -1)" class="flex h-6 w-6 items-center justify-center rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold text-xs">−</button>
                                            <span class="w-5 text-center text-xs font-bold text-slate-900" x-text="selectedAddons[addon.id]"></span>
                                            <button type="button" @click.prevent="changeQty(addon.id, 1)" class="flex h-6 w-6 items-center justify-center rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold text-xs">+</button>
                                        </div>
                                    </template>
                                    <span class="text-sm font-extrabold text-slate-900 shrink-0" x-text="formatRp(addon.price)"></span>
                                </div>
                            </label>
                        </template>
                    </div>

                    <template x-for="(addon, idx) in addons" :key="'field-'+addon.id">
                        <template x-if="selectedAddons[addon.id]">
                            <span>
                                <input type="hidden" :name="'addons['+idx+'][addon_id]'" :value="addon.id">
                                <input type="hidden" :name="'addons['+idx+'][quantity]'" :value="selectedAddons[addon.id]">
                            </span>
                        </template>
                    </template>

                    <div class="mt-8 flex justify-between items-center">
                        <button type="button" @click="step = 3" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-200 transition">Kembali</button>
                        <button type="button" @click="goNext()" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 transition">Lanjutkan</button>
                    </div>
                </div>

                {{-- Step 5: Review & Confirm --}}
                <div x-show="step === 5" x-cloak class="rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-sm">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h2 class="text-xl font-bold text-slate-900">Periksa & Konfirmasi</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Gunakan kode promo dan setujui ketentuan untuk menyelesaikan pemesanan.</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kode Promo / Kupon <span class="text-slate-400 font-normal">(Opsional)</span></label>
                            <div class="flex gap-2">
                                <input type="text" name="promo_code" x-model="promoCode" @input.debounce.500ms="refreshEstimate()" placeholder="Contoh: LIBURAN2026" class="w-full uppercase rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-900 font-bold focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <p class="mt-2 text-xs font-semibold" x-show="promoMessage" :class="promoMessage && promoMessage.type === 'applied' ? 'text-emerald-600' : 'text-red-600'" x-text="promoMessage ? promoMessage.text : ''"></p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <label for="terms" class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="terms" required id="terms" class="mt-0.5 h-4 w-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                                <span class="text-xs text-slate-600 leading-relaxed">
                                    Saya telah membaca dan menyetujui <a href="#" class="font-bold text-emerald-600 underline">Syarat &amp; Ketentuan</a> serta <a href="#" class="font-bold text-emerald-600 underline">Kebijakan Pembatalan</a> yang berlaku.
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <button type="button" @click="step = 4" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-200 transition">Kembali</button>
                        <button type="submit" :disabled="submitting" class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-7 py-3 text-sm font-extrabold text-white shadow-md hover:bg-amber-600 transition disabled:opacity-50">
                            <span x-show="!submitting">Konfirmasi &amp; Bayar</span>
                            <span x-show="submitting" x-cloak class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Live Order Summary Sidebar --}}
            <div class="lg:col-span-1">
                <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm sticky top-24">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Ringkasan Biaya</h3>
                    
                    <div class="mt-4 space-y-2.5 text-xs">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500">Dewasa × <span class="font-bold text-slate-700" x-text="counts.adult"></span></span>
                            <span class="font-semibold text-slate-900" x-text="formatRp(estimate?.price_adult * counts.adult || 0)"></span>
                        </div>
                        
                        <div class="flex justify-between items-center" x-show="counts.child > 0">
                            <span class="text-slate-500">Anak-anak × <span class="font-bold text-slate-700" x-text="counts.child"></span></span>
                            <span class="font-semibold text-slate-900" x-text="formatRp(estimate?.price_child * counts.child || 0)"></span>
                        </div>

                        <div class="flex justify-between items-center" x-show="counts.infant > 0">
                            <span class="text-slate-500">Bayi × <span class="font-bold text-slate-700" x-text="counts.infant"></span></span>
                            <span class="font-semibold text-slate-900" x-text="formatRp(estimate?.price_infant * counts.infant || 0)"></span>
                        </div>

                        <div class="flex justify-between items-center" x-show="estimate && parseFloat(estimate.addons_total) > 0">
                            <span class="text-slate-500">Layanan Tambahan</span>
                            <span class="font-semibold text-slate-900" x-text="formatRp(estimate?.addons_total || 0)"></span>
                        </div>

                        <div class="flex justify-between items-center border-t border-slate-100 pt-2.5">
                            <span class="text-slate-500 font-medium">Subtotal</span>
                            <span class="font-bold text-slate-900" x-text="formatRp(estimate?.subtotal || 0)"></span>
                        </div>

                        <div class="flex justify-between items-center text-emerald-600 font-semibold" x-show="estimate && parseFloat(estimate.discount_amount) > 0">
                            <span>Diskon Promo</span>
                            <span x-text="'- ' + formatRp(estimate?.discount_amount || 0)"></span>
                        </div>

                        <div class="flex justify-between items-baseline border-t border-slate-200/80 pt-3 text-sm font-bold text-slate-900">
                            <span>Total Biaya</span>
                            <span class="text-lg font-extrabold text-emerald-600" x-text="formatRp(estimate?.total_amount || 0)"></span>
                        </div>
                    </div>

                    <div class="mt-5 rounded-2xl bg-slate-50 p-3 text-[11px] text-slate-400 border border-slate-100 leading-relaxed">
                        Kalkulasi akhir akan diverifikasi kembali secara otomatis oleh server sebelum reservasi Anda dibuat.
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function bookingForm(config) {
    return {
        step: 1,
        completedSteps: [],
        steps: ['Perjalanan', 'Peserta', 'Data Diri', 'Tambahan', 'Konfirmasi'],
        availabilityId: config.availabilityId,
        remainingQuota: config.remainingQuota,
        addons: config.addons,
        counts: { adult: 1, child: 0, infant: 0 },
        selectedAddons: {},
        promoCode: '',
        promoMessage: null,
        estimate: null,
        submitting: false,

        totalPeserta() {
            return this.counts.adult + this.counts.child + this.counts.infant;
        },
        inc(key) { this.counts[key]++; this.refreshEstimate(); },
        dec(key) {
            const min = key === 'adult' ? 1 : 0;
            if (this.counts[key] > min) { this.counts[key]--; this.refreshEstimate(); }
        },
        toggleAddon(id) {
            if (this.selectedAddons[id]) { delete this.selectedAddons[id]; }
            else { this.selectedAddons[id] = 1; }
            this.refreshEstimate();
        },
        changeQty(id, delta) {
            if (!this.selectedAddons[id]) return;
            this.selectedAddons[id] = Math.max(1, this.selectedAddons[id] + delta);
            this.refreshEstimate();
        },
        goNext() {
            if (!this.completedSteps.includes(this.step)) this.completedSteps.push(this.step);
            this.step++;
        },
        formatRp(value) {
            const n = Number(value) || 0;
            return 'Rp ' + n.toLocaleString('id-ID', { maximumFractionDigits: 0 });
        },
        async refreshEstimate() {
            const addonsPayload = Object.entries(this.selectedAddons).map(([addon_id, quantity]) => ({ addon_id: Number(addon_id), quantity }));
            try {
                const res = await fetch(config.estimateUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': config.csrf, 'Accept': 'application/json' },
                    body: JSON.stringify({
                        availability_id: this.availabilityId,
                        adult_count: this.counts.adult,
                        child_count: this.counts.child,
                        infant_count: this.counts.infant,
                        addons: addonsPayload,
                        promo_code: this.promoCode || null,
                    }),
                });
                if (!res.ok) return;
                const data = await res.json();
                this.estimate = data.pricing;
                this.promoMessage = data.promo;
            } catch (e) { /* keep last known estimate on network error */ }
        },
        submit(e) {
            this.submitting = true;
            e.target.submit();
        },
    }
}
</script>
</x-app-layout>