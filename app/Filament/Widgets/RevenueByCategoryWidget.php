<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\OrderItem;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class RevenueByCategoryWidget extends ChartWidget
{
    protected ?string $heading = 'Revenue by Category';
    protected static ?int $sort = 1;
    protected ?string $maxHeight = '270px';
    protected int | string | array $columnSpan = '1/2';

    protected function getData(): array
    {
        $data = Category::query()
            ->select('categories.*')
            ->leftJoin('products', 'products.category_id', '=', 'categories.id')
            ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('categories.*, COALESCE(SUM(order_items.price * order_items.quantity), 0) as revenue')
            ->groupBy('categories.id')
            ->having('revenue', '>', 0)
            ->orderByDesc('revenue')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Revenue by Category',
                    'data' => $data->pluck('revenue')->toArray(),
                    'backgroundColor' => [
                        '#3b82f6', // Blue
                        '#10b981', // Green
                        '#f59e0b', // Amber
                        '#8b5cf6', // Violet
                        '#ec4899', // Pink
                        '#14b8a6', // Teal
                        '#f97316', // Orange
                    ],
                ],
            ],
            'labels' => $data->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                ],
            ],
            'scales' => [
                'y' => [
                    'display' => false,
                ],
                'x' => [
                    'display' => false,
                ],
            ],
        ];
    }

    public static function canView(): bool
    {
        return true;
    }
}
