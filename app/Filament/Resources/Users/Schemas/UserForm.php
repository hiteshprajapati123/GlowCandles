<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Select::make('role')
                    ->options(['admin' => 'Admin', 'user' => 'User'])
                    ->default('user')
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('first_name'),
                TextInput::make('last_name'),
                TextInput::make('phone')
                    ->tel(),
                DatePicker::make('date_of_birth'),
                Select::make('gender')
                    ->options([
            'male' => 'Male',
            'female' => 'Female',
            'other' => 'Other',
            'prefer_not_to_say' => 'Prefer not to say',
        ]),
                TextInput::make('billing_address_line1'),
                TextInput::make('billing_address_line2'),
                TextInput::make('billing_city'),
                TextInput::make('billing_state'),
                TextInput::make('billing_zip'),
                TextInput::make('billing_country'),
                TextInput::make('shipping_address_line1'),
                TextInput::make('shipping_address_line2'),
                TextInput::make('shipping_city'),
                TextInput::make('shipping_state'),
                TextInput::make('shipping_zip'),
                TextInput::make('shipping_country'),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_verified')
                    ->required(),
                Toggle::make('is_banned')
                    ->required(),
                DateTimePicker::make('last_login_at'),
                TextInput::make('last_login_ip'),
                TextInput::make('timezone')
                    ->required()
                    ->default('UTC'),
                TextInput::make('locale')
                    ->required()
                    ->default('en'),
                TextInput::make('currency')
                    ->required()
                    ->default('USD'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('preferences'),
            ]);
    }
}
