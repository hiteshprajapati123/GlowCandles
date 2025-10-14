<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('order_number'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('grand_total')
                    ->numeric(),
                TextEntry::make('subtotal')
                    ->numeric(),
                TextEntry::make('tax')
                    ->numeric(),
                TextEntry::make('shipping')
                    ->numeric(),
                TextEntry::make('item_count')
                    ->numeric(),
                IconEntry::make('payment_status')
                    ->boolean(),
                TextEntry::make('payment_method')
                    ->placeholder('-'),
                TextEntry::make('first_name'),
                TextEntry::make('last_name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('address')
                    ->columnSpanFull(),
                TextEntry::make('address_line2')
                    ->placeholder('-'),
                TextEntry::make('city'),
                TextEntry::make('state')
                    ->placeholder('-'),
                TextEntry::make('country'),
                TextEntry::make('post_code'),
                TextEntry::make('phone_number'),
                TextEntry::make('order_notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
