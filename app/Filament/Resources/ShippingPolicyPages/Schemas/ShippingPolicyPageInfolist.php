<?php

namespace App\Filament\Resources\ShippingPolicyPages\Schemas;

use App\Models\ShippingPolicyPage;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ShippingPolicyPageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('banner_title'),
                TextEntry::make('banner_subtitle')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('banner_image')
                    ->placeholder('-'),
                TextEntry::make('shipping_info_title'),
                TextEntry::make('shipping_info_content')
                    ->columnSpanFull(),
                TextEntry::make('delivery_times_title'),
                TextEntry::make('delivery_times_content')
                    ->columnSpanFull(),
                TextEntry::make('order_tracking_title'),
                TextEntry::make('order_tracking_content')
                    ->columnSpanFull(),
                TextEntry::make('international_shipping_title')
                    ->placeholder('-'),
                TextEntry::make('international_shipping_content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('damaged_lost_packages_title')
                    ->placeholder('-'),
                TextEntry::make('damaged_lost_packages_content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('faq_title')
                    ->placeholder('-'),
                TextEntry::make('faq_content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('contact_section_title')
                    ->placeholder('-'),
                TextEntry::make('contact_section_content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('meta_title')
                    ->placeholder('-'),
                TextEntry::make('meta_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('meta_keywords')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ShippingPolicyPage $record): bool => $record->trashed()),
            ]);
    }
}
