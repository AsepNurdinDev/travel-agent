<x-filament-widgets::widget>
    <style>
        .ta-stats-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1rem;
        }

        @media (min-width: 640px) {
            .ta-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .ta-stats-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        .ta-stat-card {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            border-radius: 0.85rem;
            padding: 1.1rem 1.15rem;
            background: var(--ta-card-bg, #ffffff);
            border: 1px solid rgba(15, 23, 42, 0.06);
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        }

        .dark .ta-stat-card {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.08);
        }

        .ta-stat-card__icon {
            flex-shrink: 0;
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ta-stat-card__icon svg {
            width: 1.5rem;
            height: 1.5rem;
        }

        .ta-stat-card__label {
            font-size: 0.78rem;
            font-weight: 500;
            color: rgb(100 116 139);
        }

        .dark .ta-stat-card__label {
            color: rgb(148 163 184);
        }

        .ta-stat-card__value {
            margin-top: 0.15rem;
            font-size: 1.35rem;
            font-weight: 700;
            line-height: 1.6rem;
            color: rgb(15 23 42);
        }

        .dark .ta-stat-card__value {
            color: rgb(241 245 249);
        }

        .ta-stat-card__desc {
            margin-top: 0.2rem;
            font-size: 0.72rem;
            color: rgb(148 163 184);
        }

        .ta-stat-card--sky .ta-stat-card__icon { background: rgba(14, 165, 233, 0.12); color: #0284c7; }
        .ta-stat-card--emerald .ta-stat-card__icon { background: rgba(16, 185, 129, 0.12); color: #059669; }
        .ta-stat-card--amber .ta-stat-card__icon { background: rgba(245, 158, 11, 0.14); color: #b45309; }
        .ta-stat-card--rose .ta-stat-card__icon { background: rgba(244, 63, 94, 0.12); color: #be123c; }
    </style>

    <div class="ta-stats-grid">
        @foreach ($this->getStats() as $stat)
            <div class="ta-stat-card ta-stat-card--{{ $stat['color'] }}">
                <div class="ta-stat-card__icon">
                    <x-filament::icon :icon="$stat['icon']" />
                </div>
                <div>
                    <div class="ta-stat-card__label">{{ $stat['label'] }}</div>
                    <div class="ta-stat-card__value">{{ $stat['value'] }}</div>
                    @if (! empty($stat['description']))
                        <div class="ta-stat-card__desc">{{ $stat['description'] }}</div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-filament-widgets::widget>
