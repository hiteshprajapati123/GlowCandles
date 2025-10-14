<?php

namespace App\Filament\Resources\ContactPages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ContactPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('banner_title')
                    ->searchable(),
                ImageColumn::make('banner_image'),
                TextColumn::make('contact_form_title')
                    ->searchable(),
                TextColumn::make('contact_info_title')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('business_hours_title')
                    ->searchable(),
                TextColumn::make('social_media_title')
                    ->searchable(),
                TextColumn::make('instagram_url')
                    ->searchable(),
                TextColumn::make('facebook_url')
                    ->searchable(),
                TextColumn::make('pinterest_url')
                    ->searchable(),
                TextColumn::make('faq_section_title')
                    ->searchable(),
                TextColumn::make('cta_section_title')
                    ->searchable(),
                TextColumn::make('cta_button_text')
                    ->searchable(),
                TextColumn::make('cta_button_link')
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
                DeleteAction::make()
                    ->action(fn ($record) => $record->forceDelete())
                    ->requiresConfirmation()
                    ->modalHeading('Permanently Delete Contact Page')
                    ->modalDescription('Are you sure you want to permanently delete this contact page? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete permanently'),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->action(fn ($records) => $records->each->forceDelete())
                        ->requiresConfirmation()
                        ->modalHeading('Permanently Delete Selected')
                        ->modalDescription('Are you sure you want to permanently delete the selected contact pages? This action cannot be undone.')
                        ->modalSubmitActionLabel('Yes, delete permanently'),
                ]),
            ])
            ->toolbarActions([
                // Bulk actions are already defined in bulkActions()
            ]);
    }
}
