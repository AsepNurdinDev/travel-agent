import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/* ===== Animasi tema travel (reveal, counter, tilt) ===== */
document.documentElement.classList.add('js');

document.addEventListener('DOMContentLoaded', () => {
    // Tandai elemen [data-reveal] sebagai .reveal (dengan delay bertahap per grup)
    document.querySelectorAll('[data-reveal]').forEach((el, i) => {
        el.classList.add('reveal');
        el.style.transitionDelay = ((i % 4) * 0.08) + 's';
    });

    // auto-reveal: kartu putih besar di dalam <main> ikut muncul halus saat di-scroll
    document.querySelectorAll('main [class*="rounded-3xl"][class*="bg-white"]:not([data-reveal]):not(.reveal)').forEach((el) => {
        if (el.closest('[x-cloak], .fixed, [class*="sticky"]')) return;
        el.classList.add('reveal');
    });

    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (!e.isIntersecting) return;
            const el = e.target;
            io.unobserve(el);
            el.classList.add('show');

            if (el.dataset.count) {
                const target = parseFloat(el.dataset.count);
                const t0 = performance.now();
                const tick = (now) => {
                    const p = Math.min((now - t0) / 1600, 1);
                    const v = target * (1 - Math.pow(1 - p, 3));
                    el.textContent = Math.round(v).toLocaleString('id-ID');
                    if (p < 1) requestAnimationFrame(tick);
                };
                requestAnimationFrame(tick);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal, [data-count]').forEach((el) => io.observe(el));

    // Tilt 3D untuk kartu [data-tilt]
    document.addEventListener('mousemove', (e) => {
        const t = e.target.closest && e.target.closest('[data-tilt]');
        document.querySelectorAll('[data-tilt]').forEach((el) => { if (el !== t) el.style.transform = ''; });
        if (!t) return;
        const r = t.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width - 0.5;
        const y = (e.clientY - r.top) / r.height - 0.5;
        t.style.transform = `perspective(900px) rotateY(${x * 6}deg) rotateX(${-y * 6}deg) translateY(-6px)`;
    });
});
