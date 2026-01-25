<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;
use Illuminate\Support\Carbon;

class AnalyticsOverviewChart extends ChartWidget
{
    protected static ?string $heading = 'Analytics Overview';

    protected string | int | array $columnSpan = 'full'; // Agar full width

    protected static ?int $sort = 1;

    // 1. Tambahkan fungsi ini untuk membuat Dropdown Filter
    protected function getFilters(): ?array
    {
        return [
            'week' => 'Last 7 Days',
            'month' => 'Last 1 Month',
            'year' => 'Last 1 Year',
        ];
    }

    protected function getData(): array
    {
        // 2. Baca filter yang dipilih user (default ke 'week' jika kosong)
        $activeFilter = $this->filter;

        // 3. Tentukan Period berdasarkan filter
        $period = match ($activeFilter) {
            'month' => Period::months(1),
            'year' => Period::years(1),
            default => Period::days(7), // Default 'week'
        };

        try {
            // Ambil data sesuai periode yang dipilih
            $data = Analytics::fetchTotalVisitorsAndPageViews($period);

            $dates = $data->map(fn($item) => $item['date']->format('d M'));
            $visitors = $data->map(fn($item) => $item['activeUsers']);
            $pageViews = $data->map(fn($item) => $item['screenPageViews']);

            return [
                'datasets' => [
                    [
                        'label' => 'Pengunjung',
                        'data' => $visitors->toArray(),
                        'borderColor' => '#3b82f6',
                        'fill' => 'start',
                    ],
                    [
                        'label' => 'Halaman Dilihat',
                        'data' => $pageViews->toArray(),
                        'borderColor' => '#10b981',
                        'fill' => 'start',
                    ],
                ],
                'labels' => $dates->toArray(),
            ];
        } catch (\Exception $e) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }
    }

    protected function getType(): string
    {
        return 'line';
    }
}