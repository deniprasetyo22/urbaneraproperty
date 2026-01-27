<?php

namespace App\Filament\Widgets;

use Log;
use Spatie\Analytics\Period;
use Illuminate\Support\Carbon;
use Filament\Widgets\ChartWidget;
use Spatie\Analytics\Facades\Analytics;

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
        $activeFilter = $this->filter;

        $period = match ($activeFilter) {
            'month' => Period::months(1),
            'year' => Period::years(1),
            default => Period::days(7),
        };

        try {
            // 1. Ambil data dan urutkan berdasarkan tanggal secara Ascending (Lama ke Baru)
            $data = Analytics::fetchTotalVisitorsAndPageViews($period)
                ->sortBy('date'); // Menambahkan pengurutan di sini

            // 2. Mapping data yang sudah berurutan
            $dates = $data->map(fn($item) => $item['date']->format('d M'));
            $visitors = $data->map(fn($item) => $item['activeUsers']);
            $pageViews = $data->map(fn($item) => $item['screenPageViews']);

            return [
                'datasets' => [
                    [
                        'label' => 'Visitors',
                        'data' => $visitors->values()->toArray(), // Gunakan values() untuk reset index
                        'borderColor' => '#3b82f6',
                        'fill' => 'start',
                    ],
                    [
                        'label' => 'Page Views',
                        'data' => $pageViews->values()->toArray(), // Gunakan values() untuk reset index
                        'borderColor' => '#10b981',
                        'fill' => 'start',
                    ],
                ],
                'labels' => $dates->values()->toArray(),
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