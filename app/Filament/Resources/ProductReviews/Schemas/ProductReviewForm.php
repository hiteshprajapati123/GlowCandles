<?php

namespace App\Filament\Resources\ProductReviews\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('product_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('rating')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('comment')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('images'),
                Toggle::make('is_approved')
                    ->required(),
                DateTimePicker::make('approved_at'),
                TextInput::make('approved_by')
                    ->numeric(),
                TextInput::make('pros'),
                TextInput::make('cons'),
                TextInput::make('helpful_yes')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('helpful_no')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
