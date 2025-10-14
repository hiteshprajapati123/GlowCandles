<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Total registered users')
                ->descriptionIcon('heroicon-o-users')
                ->color('success'),
                
            Stat::make('Total Products', Product::count())
                ->description('Available in stock')
                ->descriptionIcon('heroicon-o-cube')
                ->color('primary'),
                
            Stat::make('Total Orders', Order::count())
                ->description('All time orders')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('warning'),
                
            Stat::make('Total Revenue', '₹' . number_format(Order::sum('grand_total'), 2))
                ->description('Total sales')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),
        ];
    }

    public static function canView(): bool
    {
        return true;
    }
}
