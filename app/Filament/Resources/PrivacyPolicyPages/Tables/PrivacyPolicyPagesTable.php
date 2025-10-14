<?php

namespace App\Filament\Resources\PrivacyPolicyPages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PrivacyPolicyPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('banner_title')
                    ->searchable(),
                ImageColumn::make('banner_image'),
                TextColumn::make('introduction_title')
                    ->searchable(),
                TextColumn::make('information_collection_title')
                    ->searchable(),
                TextColumn::make('how_we_use_title')
                    ->searchable(),
                TextColumn::make('information_sharing_title')
                    ->searchable(),
                TextColumn::make('data_security_title')
                    ->searchable(),
                TextColumn::make('your_rights_title')
                    ->searchable(),
                TextColumn::make('cookies_title')
                    ->searchable(),
                TextColumn::make('third_party_links_title')
                    ->searchable(),
                TextColumn::make('children_privacy_title')
                    ->searchable(),
                TextColumn::make('policy_changes_title')
                    ->searchable(),
                TextColumn::make('contact_us_title')
                    ->searchable(),
                TextColumn::make('meta_title')
                    ->searchable(),
                IconColumn::make('is_active')
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
                    ->action(fn ($record) => $record->forceDelete())
                    ->requiresConfirmation()
                    ->modalHeading('Permanently Delete Privacy Policy Page')
                    ->modalDescription('Are you sure you want to permanently delete this privacy policy page? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete permanently'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->action(fn ($records) => $records->each->forceDelete())
                        ->requiresConfirmation()
                        ->modalHeading('Permanently Delete Selected')
                        ->modalDescription('Are you sure you want to permanently delete the selected privacy policy pages? This action cannot be undone.')
                        ->modalSubmitActionLabel('Yes, delete permanently'),
                ]),
            ])
            ->toolbarActions([
                // Bulk actions are already defined in bulkActions()
                // Using hard deletes, so we don't need ForceDeleteBulkAction or RestoreBulkAction
            ]);
    }
}
