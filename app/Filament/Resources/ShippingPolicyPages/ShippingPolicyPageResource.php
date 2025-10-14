<?php

namespace App\Filament\Resources\ShippingPolicyPages;

use App\Filament\Resources\ShippingPolicyPages\Pages\CreateShippingPolicyPage;
use App\Filament\Resources\ShippingPolicyPages\Pages\EditShippingPolicyPage;
use App\Filament\Resources\ShippingPolicyPages\Pages\ListShippingPolicyPages;
use App\Filament\Resources\ShippingPolicyPages\Pages\ViewShippingPolicyPage;
use App\Filament\Resources\ShippingPolicyPages\Schemas\ShippingPolicyPageForm;
use App\Filament\Resources\ShippingPolicyPages\Schemas\ShippingPolicyPageInfolist;
use App\Filament\Resources\ShippingPolicyPages\Tables\ShippingPolicyPagesTable;
use App\Models\ShippingPolicyPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Navigation\NavigationItem;

class ShippingPolicyPageResource extends Resource
{
    protected static ?string $model = ShippingPolicyPage::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-truck';
    
    protected static string|\UnitEnum|null $navigationGroup = 'Pages';
    
    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'shipping-policy';

    public static function getNavigationItem(): NavigationItem
    {
        return NavigationItem::make()
            ->label(static::getNavigationLabel())
            ->icon(static::getNavigationIcon())
            ->group(static::getNavigationGroup())
            ->sort(static::getNavigationSort());
    }

    public static function form(Schema $schema): Schema
    {
        return ShippingPolicyPageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ShippingPolicyPageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShippingPolicyPagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShippingPolicyPages::route('/'),
            'view' => ViewShippingPolicyPage::route('/{record}'),
            'edit' => EditShippingPolicyPage::route('/{record}/edit'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
