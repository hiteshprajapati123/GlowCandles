<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('price')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('compare_at_price')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('cost_per_item')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                TextColumn::make('barcode')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('track_quantity')
                    ->boolean(),
                IconColumn::make('sell_when_out_of_stock')
                    ->boolean(),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('status')
                    ->badge(),
                ImageColumn::make('main_image_url')
                    ->label('Image')
                    ->getStateUsing(fn ($record) => $record->main_image_url)
                    ->extraImgAttributes(['class' => 'h-12 w-12 rounded-md object-cover']),
                TextColumn::make('category_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('brand')
                    ->searchable(),
                TextColumn::make('weight')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('weight_unit')
                    ->searchable(),
                TextColumn::make('length')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('width')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('height')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dimension_unit')
                    ->searchable(),
                TextColumn::make('color')
                    ->searchable(),
                TextColumn::make('size')
                    ->searchable(),
                TextColumn::make('material')
                    ->searchable(),
                TextColumn::make('meta_title')
                    ->searchable(),
                IconColumn::make('is_featured')
                    ->boolean(),
                IconColumn::make('is_bestseller')
                    ->boolean(),
                IconColumn::make('is_new')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('view_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sold_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make(),
                DeleteAction::make()
                    ->action(fn ($record) => $record->forceDelete())
                    ->requiresConfirmation()
                    ->modalHeading('Permanently Delete Product')
                    ->modalDescription('Are you sure you want to permanently delete this product? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete permanently'),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->action(fn ($records) => $records->each->forceDelete())
                        ->requiresConfirmation()
                        ->modalHeading('Permanently Delete Selected')
                        ->modalDescription('Are you sure you want to permanently delete the selected products? This action cannot be undone.')
                        ->modalSubmitActionLabel('Yes, delete permanently'),
                ]),
            ])
            ->toolbarActions([
                // Bulk actions are already defined in bulkActions()
            ]);
    }
}
