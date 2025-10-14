<?php

namespace App\Filament\Resources\ShippingPolicyPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ShippingPolicyPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('banner_title')
                    ->required(),
                Textarea::make('banner_subtitle')
                    ->columnSpanFull(),
                FileUpload::make('banner_image')
                    ->image(),
                TextInput::make('shipping_info_title')
                    ->required(),
                Textarea::make('shipping_info_content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('delivery_times_title')
                    ->required(),
                Textarea::make('delivery_times_content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('order_tracking_title')
                    ->required(),
                Textarea::make('order_tracking_content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('international_shipping_title'),
                Textarea::make('international_shipping_content')
                    ->columnSpanFull(),
                TextInput::make('damaged_lost_packages_title'),
                Textarea::make('damaged_lost_packages_content')
                    ->columnSpanFull(),
                TextInput::make('faq_title'),
                Textarea::make('faq_content')
                    ->columnSpanFull(),
                TextInput::make('contact_section_title'),
                Textarea::make('contact_section_content')
                    ->columnSpanFull(),
                TextInput::make('meta_title'),
                Textarea::make('meta_description')
                    ->columnSpanFull(),
                Textarea::make('meta_keywords')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
