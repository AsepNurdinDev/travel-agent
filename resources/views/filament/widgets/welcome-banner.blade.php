<x-filament-widgets::widget>
    <style>
        .ta-hero {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            padding: 1.75rem 2rem;
            background: linear-gradient(120deg, #0ea5e9 0%, #0284c7 45%, #f97316 130%);
            color: #ffffff;
            box-shadow: 0 10px 25px -10px rgba(2, 132, 199, 0.45);
        }

        .ta-hero__decor {
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: 0.16;
        }

        .ta-hero__decor svg {
            position: absolute;
            top: -20px;
            right: -10px;
            width: 220px;
            height: 220px;
        }

        .ta-hero__content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
        }

        .ta-hero__greeting {
            font-size: 0.875rem;
            font-weight: 500;
            letter-spacing: 0.02em;
            color: rgba(255, 255, 255, 0.85);
            text-transform: uppercase;
        }

        .ta-hero__title {
            margin-top: 0.25rem;
            font-size: 1.5rem;
            line-height: 2rem;
            font-weight: 700;
        }

        .ta-hero__subtitle {
            margin-top: 0.35rem;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .ta-hero__date {
            font-size: 0.8rem;
            background: rgba(255, 255, 255, 0.16);
            padding: 0.4rem 0.85rem;
            border-radius: 999px;
            white-space: nowrap;
        }
    </style>

    <div class="ta-hero">
        <div class="ta-hero__decor">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M22 15.5c0 .3-.2.5-.5.5H16l-2.6 4a1 1 0 0 1-1.7-.1L10.2 16H4.5a.5.5 0 0 1-.4-.8l2.1-2.8-2.1-2.8a.5.5 0 0 1 .4-.8h5.7l1.6-4.4a1 1 0 0 1 1.7-.1L16 9h5.5c.3 0 .5.2.5.5v6Z" />
            </svg>
        </div>

        <div class="ta-hero__content">
            <div>
                <div class="ta-hero__greeting">{{ $this->getGreeting() }}, {{ $this->getUserName() }} 👋</div>
                <div class="ta-hero__title">Selamat datang di Panel Travel Agent</div>
                <div class="ta-hero__subtitle">Pantau booking, pendapatan, dan jadwal keberangkatan dalam satu tempat.</div>
            </div>

            <div class="ta-hero__date">
                {{ $this->getTodayLabel() }}
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
