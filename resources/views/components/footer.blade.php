<footer class="border-t border-slate-100 bg-ink text-slate-300">
    <div class="container-page py-14 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary text-white font-bold">N</span>
                <span class="text-lg font-bold text-white">{{ \App\Models\Setting::getValue('site_name', 'Nusantara Journeys') }}</span>
            </div>
            <p class="mt-4 text-sm leading-relaxed text-slate-400">
                {{ \App\Models\Setting::getValue('site_tagline', 'Thoughtfully planned tours across Indonesia\'s islands, reefs and highlands — handled by a team that knows the way.') }}
            </p>
            <div class="mt-5 flex gap-3">
                @foreach (['Instagram','Facebook','TikTok'] as $s)
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-xs">{{ substr($s,0,1) }}</span>
                @endforeach
            </div>
        </div>

        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Explore</h4>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="{{ route('destinations.index') }}" class="hover:text-primary-200">Destinations</a></li>
                <li><a href="{{ route('tours.index') }}" class="hover:text-primary-200">Tour Packages</a></li>
                <li><a href="{{ route('blog.index') }}" class="hover:text-primary-200">Travel Blog</a></li>
                <li><a href="{{ route('gallery.index') }}" class="hover:text-primary-200">Gallery</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Company</h4>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="{{ route('about') }}" class="hover:text-primary-200">About Us</a></li>
                <li><a href="{{ route('contact.index') }}" class="hover:text-primary-200">Contact</a></li>
                <li><a href="{{ route('login') }}" class="hover:text-primary-200">Sign In</a></li>
                <li><a href="{{ route('register') }}" class="hover:text-primary-200">Create Account</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Contact</h4>
            <ul class="mt-4 space-y-2.5 text-sm text-slate-400">
                <li>{{ \App\Models\Setting::getValue('contact_address', 'Jl. Merdeka No. 1, Bandung, Indonesia') }}</li>
                <li>{{ \App\Models\Setting::getValue('contact_phone', '+62 21 555 0123') }}</li>
                <li>{{ \App\Models\Setting::getValue('contact_email', 'hello@nusantarajourneys.test') }}</li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-page py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <p>&copy; {{ now()->year }} {{ \App\Models\Setting::getValue('site_name', 'Nusantara Journeys') }}. All rights reserved.</p>
            <div class="flex gap-4">
                <span>Privacy Policy</span>
                <span>Terms of Service</span>
            </div>
        </div>
    </div>
</footer>
