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
    x-init="refreshEstimate()"
    class="container-page py-10"
>
    {{-- Stepper --}}
    <div class="mb-8 flex items-center justify-between overflow-x-auto pb-2">
        <template x-for="(label, i) in steps" :key="i">
            <div class="flex items-center shrink-0">
                <div class="flex items-center gap-2 cursor-pointer" @click="if (i + 1 < step || completedSteps.includes(i+1)) step = i + 1">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full text-xs font-bold transition"
                          :class="step === i + 1 ? 'bg-primary text-white' : (step > i + 1 ? 'bg-primary-100 text-primary' : 'bg-slate-100 text-muted')"
                          x-text="i + 1"></span>
                    <span class="hidden sm:inline text-sm font-medium" :class="step === i + 1 ? 'text-ink' : 'text-muted'" x-text="label"></span>
                </div>
                <div class="mx-3 h-px w-8 bg-slate-200 hidden sm:block" x-show="i < steps.length - 1"></div>
            </div>
        </template>
    </div>

    <form @submit.prevent="submit" method="POST" :action="'{{ route('booking.store', $availability) }}'">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">

                {{-- Step 1: Trip --}}
                <div x-show="step === 1" class="card p-6">
                    <h2 class="text-lg font-bold text-ink">Detail Perjalanan</h2>
                    <div class="mt-4 flex gap-4">
                        <img src="{{ $tourPackage->cover_image ? asset('storage/'.$tourPackage->cover_image) : 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=300&q=60' }}"
                             class="h-24 w-32 shrink-0 rounded-lg object-cover" alt="">
                        <div>
                            <p class="text-xs font-semibold uppercase text-primary">{{ $tourPackage->destination->name }}</p>
                            <h3 class="font-bold text-ink">{{ $tourPackage->name }}</h3>
                            <p class="mt-1 text-sm text-muted">{{ $tourPackage->duration_days }} Days / {{ $tourPackage->duration_nights }} Nights</p>
                            <p class="mt-1 text-sm text-muted">Berangkat: <span class="font-medium text-ink">{{ $availability->departure_date->format('d M Y') }}</span> — Pulang: <span class="font-medium text-ink">{{ $availability->return_date->format('d M Y') }}</span></p>
                            <p class="mt-1 text-xs text-emerald-600 font-medium" x-text="remainingQuota + ' kursi tersisa'"></p>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="button" @click="goNext()" class="btn-primary">Lanjutkan</button>
                    </div>
                </div>

                {{-- Step 2: Peserta --}}
                <div x-show="step === 2" class="card p-6">
                    <h2 class="text-lg font-bold text-ink">Peserta</h2>
                    <p class="text-sm text-muted">Tell us who's coming along.</p>

                    <div class="mt-5 divide-y divide-slate-100">
                        @foreach ([['key'=>'adult','label'=>'Dewasa','desc'=>'Usia 12 tahun ke atas'],['key'=>'child','label'=>'Anak-anak','desc'=>'Usia 2–11 tahun'],['key'=>'infant','label'=>'Bayi','desc'=>'Di bawah 2 tahun']] as $p)
                        <div class="flex items-center justify-between py-4">
                            <div>
                                <p class="font-medium text-ink">{{ $p['label'] }}</p>
                                <p class="text-xs text-muted">{{ $p['desc'] }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button type="button" @click="dec('{{ $p['key'] }}')" class="flex h-8 w-8 items-center justify-center rounded-full border border-slate-300 text-ink hover:border-primary hover:text-primary">−</button>
                                <span class="w-6 text-center font-semibold" x-text="counts.{{ $p['key'] }}"></span>
                                <button type="button" @click="inc('{{ $p['key'] }}')" class="flex h-8 w-8 items-center justify-center rounded-full border border-slate-300 text-ink hover:border-primary hover:text-primary">+</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="adult_count" :value="counts.adult">
                    <input type="hidden" name="child_count" :value="counts.child">
                    <input type="hidden" name="infant_count" :value="counts.infant">
                    <p x-show="totalPeserta() > remainingQuota" x-cloak class="mt-2 text-sm text-red-600">Only <span x-text="remainingQuota"></span> seats remain for this departure.</p>

                    <div class="mt-6 flex justify-between">
                        <button type="button" @click="step = 1" class="btn-outline">Back</button>
                        <button type="button" @click="goNext()" :disabled="totalPeserta() < 1 || totalPeserta() > remainingQuota" class="btn-primary">Lanjutkan</button>
                    </div>
                </div>

                {{-- Step 3: Customer --}}
                <div x-show="step === 3" class="card p-6">
                    <h2 class="text-lg font-bold text-ink">Data Diri Anda</h2>
                    <p class="text-sm text-muted">We'll use this to confirm your booking and send updates.</p>

                    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="label">Full Nama</label>
                            <input type="text" name="name" required maxlength="255" value="{{ old('name', $customer->name ?? auth()->user()->name) }}" class="input">
                        </div>
                        <div>
                            <label class="label">Email</label>
                            <input type="email" value="{{ auth()->user()->email }}" disabled class="input bg-slate-50 text-muted">
                        </div>
                        <div>
                            <label class="label">Phone</label>
                            <input type="text" name="phone" required maxlength="20" value="{{ old('phone', $customer->phone ?? '') }}" class="input">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="label">Address <span class="text-muted font-normal">(optional)</span></label>
                            <input type="text" name="address" maxlength="500" value="{{ old('address', $customer->address ?? '') }}" class="input">
                        </div>
                        <div>
                            <label class="label">ID / Passport Number <span class="text-muted font-normal">(optional)</span></label>
                            <input type="text" name="identity_number" maxlength="50" value="{{ old('identity_number', $customer->identity_number ?? '') }}" class="input">
                        </div>
                        <div>
                            <label class="label">Date of Birth <span class="text-muted font-normal">(optional)</span></label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($customer->date_of_birth ?? null)->format('Y-m-d')) }}" class="input">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="label">Notes for our team <span class="text-muted font-normal">(optional)</span></label>
                            <textarea name="notes" rows="2" maxlength="1000" class="input">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <button type="button" @click="step = 2" class="btn-outline">Back</button>
                        <button type="button" @click="goNext()" class="btn-primary">Lanjutkan</button>
                    </div>
                </div>

                {{-- Step 4: Add-ons --}}
                <div x-show="step === 4" class="card p-6">
                    <h2 class="text-lg font-bold text-ink">Add-ons</h2>
                    <p class="text-sm text-muted">Optional extras to enhance your trip.</p>

                    <div class="mt-5 space-y-3">
                        <template x-if="addons.length === 0">
                            <p class="text-sm text-muted">No add-ons available for this tour.</p>
                        </template>
                        <template x-for="addon in addons" :key="addon.id">
                            <label class="flex items-center justify-between rounded-lg border px-4 py-3 cursor-pointer"
                                   :class="selectedAddons[addon.id] ? 'border-primary bg-primary-50/50' : 'border-slate-200'">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" :checked="!!selectedAddons[addon.id]" @change="toggleAddon(addon.id)" class="h-4 w-4 rounded text-primary focus:ring-primary">
                                    <div>
                                        <p class="text-sm font-semibold text-ink" x-text="addon.name"></p>
                                        <p class="text-xs text-muted" x-text="addon.description"></p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <template x-if="selectedAddons[addon.id]">
                                        <div class="flex items-center gap-2">
                                            <button type="button" @click.prevent="changeQty(addon.id, -1)" class="flex h-6 w-6 items-center justify-center rounded-full border border-slate-300">−</button>
                                            <span class="w-4 text-center text-sm" x-text="selectedAddons[addon.id]"></span>
                                            <button type="button" @click.prevent="changeQty(addon.id, 1)" class="flex h-6 w-6 items-center justify-center rounded-full border border-slate-300">+</button>
                                        </div>
                                    </template>
                                    <span class="text-sm font-semibold text-primary shrink-0" x-text="formatRp(addon.price)"></span>
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

                    <div class="mt-6 flex justify-between">
                        <button type="button" @click="step = 3" class="btn-outline">Back</button>
                        <button type="button" @click="goNext()" class="btn-primary">Lanjutkan</button>
                    </div>
                </div>

                {{-- Step 5: Beri Ulasan --}}
                <div x-show="step === 5" class="card p-6">
                    <h2 class="text-lg font-bold text-ink">Periksa &amp; Promo</h2>

                    <div class="mt-4">
                        <label class="label">Promo Code <span class="text-muted font-normal">(optional)</span></label>
                        <div class="flex gap-2">
                            <input type="text" name="promo_code" x-model="promoCode" @input.debounce.500ms="refreshEstimate()" placeholder="e.g. SUMMER10" class="input uppercase">
                        </div>
                        <p class="mt-1.5 text-sm" x-show="promoMessage" :class="promoMessage && promoMessage.type === 'applied' ? 'text-emerald-600' : 'text-red-600'" x-text="promoMessage ? promoMessage.text : ''"></p>
                    </div>

                    <div class="mt-6 flex items-start gap-2">
                        <input type="checkbox" name="terms" required id="terms" class="mt-0.5 h-4 w-4 rounded text-primary focus:ring-primary">
                        <label for="terms" class="text-sm text-muted">I agree to the <span class="text-primary font-medium">Terms &amp; Conditions</span> and <span class="text-primary font-medium">Batallation Policy</span>.</label>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <button type="button" @click="step = 4" class="btn-outline">Back</button>
                        <button type="submit" :disabled="submitting" class="btn-accent">
                            <span x-show="!submitting">Konfirmasi Pesanan</span>
                            <span x-show="submitting" x-cloak>Processing…</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Live summary sidebar --}}
            <div class="lg:col-span-1">
                <div class="card sticky top-24 p-6">
                    <h3 class="font-bold text-ink">Ringkasan Harga</h3>
                    <div class="mt-4 space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-muted">Dewasa × <span x-text="counts.adult"></span></span><span x-text="formatRp(estimate?.price_adult * counts.adult || 0)"></span></div>
                        <div class="flex justify-between" x-show="counts.child > 0"><span class="text-muted">Anak-anak × <span x-text="counts.child"></span></span><span x-text="formatRp(estimate?.price_child * counts.child || 0)"></span></div>
                        <div class="flex justify-between" x-show="counts.infant > 0"><span class="text-muted">Bayi × <span x-text="counts.infant"></span></span><span x-text="formatRp(estimate?.price_infant * counts.infant || 0)"></span></div>
                        <div class="flex justify-between" x-show="estimate && parseFloat(estimate.addons_total) > 0"><span class="text-muted">Add-ons</span><span x-text="formatRp(estimate?.addons_total || 0)"></span></div>
                        <div class="flex justify-between border-t border-slate-100 pt-2"><span class="text-muted">Subtotal</span><span x-text="formatRp(estimate?.subtotal || 0)"></span></div>
                        <div class="flex justify-between text-emerald-600" x-show="estimate && parseFloat(estimate.discount_amount) > 0"><span>Discount</span><span x-text="'- ' + formatRp(estimate?.discount_amount || 0)"></span></div>
                        <div class="flex justify-between border-t border-slate-100 pt-3 text-base font-bold text-ink">
                            <span>Total</span>
                            <span x-text="formatRp(estimate?.total_amount || 0)"></span>
                        </div>
                    </div>
                    <p class="mt-3 text-xs text-muted">Final pricing is always calculated and verified by our server before your booking is created.</p>
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
        steps: ['Perjalanan', 'Peserta', 'Data Diri', 'Tambahan', 'Beri Ulasan'],
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
