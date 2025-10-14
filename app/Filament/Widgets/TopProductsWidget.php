<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use App\Models\Product;
use Filament\Widgets\TableWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\DB;

class TopProductsWidget extends TableWidget
{
    protected static ?int $sort = 0; // This will place it before SalesChart (sort=1)
    protected static ?string $heading = 'Top Selling Products';
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Product::query()
            ->select('products.*')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('products.*, SUM(order_items.quantity) as total_quantity')
            ->groupBy('products.id')
            ->orderByDesc('total_quantity')
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            ImageColumn::make('main_image')
                ->label('')
                ->circular()
                ->defaultImageUrl(fn () => 'https://via.placeholder.com/40'),
                
            TextColumn::make('name')
                ->label('Product Name')
                ->searchable()
                ->sortable(),
                
            TextColumn::make('price')
                ->label('Price')
                ->money('INR')
                ->sortable(),
                
            TextColumn::make('total_quantity')
                ->label('Units Sold')
                ->sortable()
                ->formatStateUsing(fn ($state) => number_format($state)),
                
            TextColumn::make('revenue')
                ->label('Total Revenue')
                ->money('INR')
                ->getStateUsing(fn ($record) => $record->price * $record->total_quantity),
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    public static function canView(): bool
    {
        return true;
    }
}
