<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->formatStateUsing(fn ($state, $record) => "{$state} (ID: {$record->user_id})")
                    ->searchable(query: function ($query, $search) {
                        return $query->whereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                              ->orWhere('id', $search);
                        });
                    }),
                TextColumn::make('order_number')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('grand_total')
                    ->numeric()
                    ->sortable()
                    ->weight('bold')
                    ->money('INR')  // or your preferred currency
                    ->color('primary')
                    ->description('Grand Total', position: 'above')
                    ->searchable(),
                TextColumn::make('subtotal')
                    ->numeric()
                    ->sortable()
                    ->money('INR'),
                TextColumn::make('tax')
                    ->numeric()
                    ->sortable()
                    ->money('INR'),
                TextColumn::make('shipping')
                    ->numeric()
                    ->sortable()
                    ->money('INR'),
                TextColumn::make('item_count')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('payment_status')
                    ->boolean(),
                TextColumn::make('payment_method')
                    ->searchable(),
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('address_line2')
                    ->searchable(),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('state')
                    ->searchable(),
                TextColumn::make('country')
                    ->searchable(),
                TextColumn::make('post_code')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                DeleteAction::make()
                    ->action(fn ($record) => $record->forceDelete())
                    ->requiresConfirmation()
                    ->modalHeading('Permanently Delete Order')
                    ->modalDescription('Are you sure you want to permanently delete this order? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete permanently'),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->action(fn ($records) => $records->each->forceDelete())
                        ->requiresConfirmation()
                        ->modalHeading('Permanently Delete Selected')
                        ->modalDescription('Are you sure you want to permanently delete the selected orders? This action cannot be undone.')
                        ->modalSubmitActionLabel('Yes, delete permanently'),
                ]),
            ])
            ->toolbarActions([
                // Bulk actions are already defined in bulkActions()
            ]);
    }
}
