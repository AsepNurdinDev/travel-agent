<x-app-layout title="Ulasan Saya">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        {{-- Section 1: Reviewable Bookings --}}
        @if ($reviewableBookings->isNotEmpty())
            <div class="space-y-4">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">Perjalanan Menunggu Ulasan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Bagikan pengalaman Anda untuk membantu wisatawan lainnya.</p>
                </div>

                <div class="space-y-4" x-data="{ openBooking: null }">
                    @foreach ($reviewableBookings as $booking)
                        <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm transition">
                            {{-- Header Item --}}
                            <div class="flex items-center justify-between gap-4">
                                <div class="min-w-0 space-y-0.5">
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-600">
                                        {{ $booking->tourPackage->destination->name ?? 'Destinasi Wisata' }}
                                    </span>
                                    <h3 class="text-sm sm:text-base font-bold text-slate-900 truncate">
                                        {{ $booking->tourPackage->name }}
                                    </h3>
                                </div>
                                <button type="button"
                                        @click="openBooking = openBooking === {{ $booking->id }} ? null : {{ $booking->id }}" 
                                        class="shrink-0 inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition">
                                    <span x-text="openBooking === {{ $booking->id }} ? 'Batal' : 'Tulis Ulasan'"></span>
                                </button>
                            </div>

                            {{-- Collapsible Form --}}
                            <div x-show="openBooking === {{ $booking->id }}" 
                                 x-cloak 
                                 x-collapse
                                 x-data="{ rating: 5 }" 
                                 class="mt-5 border-t border-slate-100 pt-5 space-y-4">
                                
                                <form method="POST" action="{{ route('account.reviews.store') }}" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                                    {{-- Star Rating Picker --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Penilaian Anda</label>
                                        <div class="flex items-center gap-1">
                                            <template x-for="i in 5" :key="i">
                                                <button type="button" @click="rating = i" class="p-1 text-slate-200 hover:scale-110 transition-transform">
                                                    <svg class="h-8 w-8" :class="i <= rating ? 'text-amber-400 fill-amber-400' : 'text-slate-200 fill-slate-200'" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.363 1.118l1.286 3.957c.3.922-.755 1.688-1.538 1.118L10.5 15.583a1 1 0 00-1.176 0l-3.367 2.447c-.783.57-1.838-.196-1.538-1.118l1.285-3.957a1 1 0 00-.362-1.118L2.973 9.386c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69z"/>
                                                    </svg>
                                                </button>
                                            </template>
                                        </div>
                                        <input type="hidden" name="rating" x-bind:value="rating">
                                    </div>

                                    {{-- Title --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                            Judul Ulasan <span class="text-slate-400 font-normal capitalize">(Opsional)</span>
                                        </label>
                                        <input type="text" 
                                               name="title" 
                                               maxlength="255" 
                                               placeholder="Contoh: Perjalanan yang sangat berkesan!"
                                               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs sm:text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition">
                                    </div>

                                    {{-- Comment --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Ulasan Anda</label>
                                        <textarea name="comment" 
                                                  rows="3" 
                                                  maxlength="2000" 
                                                  required 
                                                  placeholder="Ceritakan pengalaman unik Anda selama mengikuti paket tour ini..."
                                                  class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs sm:text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition resize-none"></textarea>
                                    </div>

                                    <button type="submit" 
                                            class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-emerald-700 active:scale-[0.99] transition">
                                        <span>Kirim Ulasan</span>
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Section 2: Submitted Reviews --}}
        <div class="space-y-4">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">Riwayat Ulasan Saya</h2>
                <p class="text-xs text-slate-500 mt-0.5">Daftar ulasan yang telah Anda berikan untuk perjalanan Anda.</p>
            </div>

            @if ($myReviews->isEmpty())
                <x-empty-state 
                    title="Belum Ada Ulasan" 
                    description="Selesaikan perjalanan Anda untuk memberikan ulasan pertama." />
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($myReviews as $review)
                        <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm space-y-3 flex flex-col justify-between">
                            <div class="space-y-2">
                                <div class="flex items-start justify-between gap-3">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-600 line-clamp-1">
                                        {{ $review->tourPackage->name ?? 'Paket Wisata' }}
                                    </h4>
                                    @if (!$review->is_approved)
                                        <span class="shrink-0 rounded-lg bg-amber-50 px-2 py-0.5 text-[10px] font-bold text-amber-700 border border-amber-200/60">
                                            Menunggu Persetujuan
                                        </span>
                                    @else
                                        <span class="shrink-0 rounded-lg bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-700 border border-emerald-200/60">
                                            Disetujui
                                        </span>
                                    @endif
                                </div>

                                {{-- Rating Component --}}
                                <div class="flex items-center gap-1 text-amber-400">
                                    <x-rating :value="$review->rating" />
                                </div>

                                @if ($review->title)
                                    <p class="text-xs sm:text-sm font-extrabold text-slate-900 line-clamp-1">
                                        {{ $review->title }}
                                    </p>
                                @endif

                                <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                    "{{ $review->comment }}"
                                </p>
                            </div>

                            <p class="text-[10px] text-slate-400 font-medium pt-2 border-t border-slate-100">
                                Dikirakan pada {{ $review->created_at->format('d M Y') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>