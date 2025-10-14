<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('role')
                    ->badge(),
                TextEntry::make('email_verified_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('first_name')
                    ->placeholder('-'),
                TextEntry::make('last_name')
                    ->placeholder('-'),
                TextEntry::make('phone')
                    ->placeholder('-'),
                TextEntry::make('date_of_birth')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('gender')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('billing_address_line1')
                    ->placeholder('-'),
                TextEntry::make('billing_address_line2')
                    ->placeholder('-'),
                TextEntry::make('billing_city')
                    ->placeholder('-'),
                TextEntry::make('billing_state')
                    ->placeholder('-'),
                TextEntry::make('billing_zip')
                    ->placeholder('-'),
                TextEntry::make('billing_country')
                    ->placeholder('-'),
                TextEntry::make('shipping_address_line1')
                    ->placeholder('-'),
                TextEntry::make('shipping_address_line2')
                    ->placeholder('-'),
                TextEntry::make('shipping_city')
                    ->placeholder('-'),
                TextEntry::make('shipping_state')
                    ->placeholder('-'),
                TextEntry::make('shipping_zip')
                    ->placeholder('-'),
                TextEntry::make('shipping_country')
                    ->placeholder('-'),
                IconEntry::make('is_active')
                    ->boolean(),
                IconEntry::make('is_verified')
                    ->boolean(),
                IconEntry::make('is_banned')
                    ->boolean(),
                TextEntry::make('last_login_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('last_login_ip')
                    ->placeholder('-'),
                TextEntry::make('timezone'),
                TextEntry::make('locale'),
                TextEntry::make('currency'),
                TextEntry::make('notes')
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
