<?php

namespace App\Filament\Resources\PrivacyPolicyPages;

use App\Filament\Resources\PrivacyPolicyPages\Pages\CreatePrivacyPolicyPage;
use App\Filament\Resources\PrivacyPolicyPages\Pages\EditPrivacyPolicyPage;
use App\Filament\Resources\PrivacyPolicyPages\Pages\ListPrivacyPolicyPages;
use App\Filament\Resources\PrivacyPolicyPages\Pages\ViewPrivacyPolicyPage;
use App\Filament\Resources\PrivacyPolicyPages\Schemas\PrivacyPolicyPageForm;
use App\Filament\Resources\PrivacyPolicyPages\Schemas\PrivacyPolicyPageInfolist;
use App\Filament\Resources\PrivacyPolicyPages\Tables\PrivacyPolicyPagesTable;
use App\Models\PrivacyPolicyPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Navigation\NavigationItem;

class PrivacyPolicyPageResource extends Resource
{
    protected static ?string $model = PrivacyPolicyPage::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';
    
    protected static string|\UnitEnum|null $navigationGroup = 'Pages';
    
    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'privacy-policy';

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
        return PrivacyPolicyPageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PrivacyPolicyPageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrivacyPolicyPagesTable::configure($table);
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
            'index' => ListPrivacyPolicyPages::route('/'),
            'view' => ViewPrivacyPolicyPage::route('/{record}'),
            'edit' => EditPrivacyPolicyPage::route('/{record}/edit'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }

    // Using hard deletes, so no need to handle soft deletes
}
