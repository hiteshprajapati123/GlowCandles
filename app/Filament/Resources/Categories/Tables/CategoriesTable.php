<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                ImageColumn::make('image')
                    ->getStateUsing(fn ($record) => $record->featured_image_url)
                    ->extraImgAttributes(['class' => 'h-12 w-12 rounded-full object-cover']),
                TextColumn::make('icon')
                    ->searchable(),
                TextColumn::make('parent_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('meta_title')
                    ->searchable(),
                TextColumn::make('position')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                IconColumn::make('is_featured')
                    ->boolean(),
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
                EditAction::make(),
                DeleteAction::make()
                    ->action(fn (\App\Models\Category $record) => $record->forceDelete())
                    ->requiresConfirmation()
                    ->modalHeading('Permanently Delete Category')
                    ->modalDescription('Are you sure you want to permanently delete this category? This action cannot be undone and will remove all associated data.')
                    ->modalSubmitActionLabel('Yes, delete permanently')
                    ->hidden(fn (\App\Models\Category $record): bool => $record->products()->exists())
                    ->tooltip(fn (\App\Models\Category $record): string => $record->products()->exists() ? 'Cannot delete category with associated products' : '')
                    ->disabled(fn (\App\Models\Category $record): bool => $record->products()->exists())
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $categoriesWithProducts = $records->filter(fn ($record) => $record->products()->exists());
                            
                            if ($categoriesWithProducts->isNotEmpty()) {
                                $categoryNames = $categoriesWithProducts->pluck('name')->implode(', ');
                                throw new \Exception("Cannot delete categories with products: $categoryNames");
                            }
                            
                            $records->each->forceDelete();
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Permanently Delete Selected Categories')
                        ->modalDescription('Are you sure you want to permanently delete the selected categories? This action cannot be undone and will remove all associated data.')
                        ->modalSubmitActionLabel('Yes, delete permanently')
                ])
            ])
            ->toolbarActions([
                // Bulk actions are already defined in bulkActions()
            ]);
    }
}
