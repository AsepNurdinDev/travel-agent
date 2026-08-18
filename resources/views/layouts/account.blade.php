<x-app-layout :title="$title ?? 'Akun Saya'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10">
        
        {{-- Main Grid Wrapper with Alpine Drawer State --}}
        <div x-data="{ 
                drawerOpen: false,
                toggleDrawer() {
                    this.drawerOpen = !this.drawerOpen;
                    document.body.classList.toggle('overflow-hidden', this.drawerOpen);
                },
                closeDrawer() {
                    this.drawerOpen = false;
                    document.body.classList.remove('overflow-hidden');
                }
             }" 
             class="lg:grid lg:grid-cols-[260px_1fr] lg:gap-8 lg:items-start">

            {{-- Mobile Header & Trigger Button --}}
            <div class="mb-6 flex items-center justify-between rounded-2xl border border-slate-100 bg-white p-4 shadow-sm lg:hidden">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pengaturan</span>
                    <h1 class="text-lg font-extrabold text-slate-900 tracking-tight">{{ $title ?? 'Akun Saya' }}</h1>
                </div>
                <button type="button" 
                        @click="toggleDrawer()" 
                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-slate-100 active:scale-95 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span>Menu</span>
                </button>
            </div>

            {{-- Desktop Sticky Sidebar --}}
            <aside class="hidden lg:block lg:sticky lg:top-24">
                <div class="rounded-3xl border border-slate-100 bg-white p-4 shadow-sm">
                    <x-account-sidebar />
                </div>
            </aside>

            {{-- Mobile Drawer Overlay & Sidebar --}}
            <div x-show="drawerOpen" 
                 x-cloak 
                 class="relative z-50 lg:hidden">
                
                {{-- Backdrop --}}
                <div x-show="drawerOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="closeDrawer()" 
                     class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

                {{-- Drawer Panel --}}
                <div class="fixed inset-y-0 left-0 flex w-full max-w-xs flex-col bg-white shadow-2xl">
                    
                    {{-- Drawer Header --}}
                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                        <div class="flex items-center gap-2">
                            <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                            <span class="text-sm font-bold text-slate-900">Menu Akun</span>
                        </div>
                        <button type="button" 
                                @click="closeDrawer()" 
                                class="rounded-xl p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Drawer Content / Sidebar Links --}}
                    <div class="flex-1 overflow-y-auto p-4">
                        <x-account-sidebar />
                    </div>
                </div>
            </div>

            {{-- Main Content Area --}}
            <main class="min-w-0">
                {{ $slot }}
            </main>

        </div>
    </div>
</x-app-layout>