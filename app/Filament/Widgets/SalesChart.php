<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SalesChart extends ChartWidget
{
    protected ?string $heading = 'Sales Overview';
    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $data = $this->getSalesData();

        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $data['salesData'],
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => '#3b82f6',
                    'fill' => false,
                ],
                [
                    'label' => 'Orders',
                    'data' => $data['ordersData'],
                    'borderColor' => '#10b981',
                    'backgroundColor' => '#10b981',
                    'fill' => false,
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "$" + value; }',
                    ],
                ],
            ],
        ];
    }

    private function getSalesData(): array
    {
        $now = now();
        $salesData = [];
        $ordersData = [];
        $labels = [];

        // Get data for the last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $startOfDay = $date->copy()->startOfDay();
            $endOfDay = $date->copy()->endOfDay();

            $sales = Order::whereBetween('created_at', [$startOfDay, $endOfDay])->sum('grand_total');
            $orders = Order::whereBetween('created_at', [$startOfDay, $endOfDay])->count();

            $salesData[] = round($sales, 2);
            $ordersData[] = $orders;
            $labels[] = $date->format('M d');
        }

        return [
            'salesData' => $salesData,
            'ordersData' => $ordersData,
            'labels' => $labels,
        ];
    }

    public static function canView(): bool
    {
        return true;
    }
}
