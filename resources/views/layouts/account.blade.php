<x-app-layout :title="$title ?? 'Akun Saya'">
    <div class="container-page py-8 lg:py-10">
        <div x-data="{ drawerOpen: false }" class="lg:grid lg:grid-cols-[260px_1fr] lg:gap-8">

            <div class="mb-4 flex items-center justify-between lg:hidden">
                <h1 class="text-xl font-bold text-ink">{{ $title ?? 'Akun Saya' }}</h1>
                <button @click="drawerOpen = true" class="btn-outline !py-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    Menu
                </button>
            </div>

            <aside class="hidden lg:block">
                <div class="card sticky top-24 p-4">
                    <x-account-sidebar />
                </div>
            </aside>

            <div x-show="drawerOpen" x-cloak class="lg:hidden">
                <div @click="drawerOpen = false" class="fixed inset-0 z-40 bg-ink/40"></div>
                <div class="fixed inset-y-0 left-0 z-50 w-72 overflow-y-auto bg-white p-4 shadow-xl">
                    <div class="mb-4 flex items-center justify-between">
                        <span class="font-bold text-ink">Menu Akun</span>
                        <button @click="drawerOpen = false" class="p-1 text-muted hover:text-ink">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <x-account-sidebar />
                </div>
            </div>

            <div class="min-w-0">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>
