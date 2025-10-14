<?php

namespace App\Filament\Resources\ContactPages\Schemas;

use App\Models\ContactPage;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContactPageInfolist
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
                TextEntry::make('contact_form_title'),
                TextEntry::make('contact_form_subtitle')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('contact_info_title'),
                TextEntry::make('contact_info_subtitle')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('phone'),
                TextEntry::make('address')
                    ->columnSpanFull(),
                TextEntry::make('business_hours_title')
                    ->placeholder('-'),
                TextEntry::make('business_hours_content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('social_media_title')
                    ->placeholder('-'),
                TextEntry::make('social_media_subtitle')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('instagram_url')
                    ->placeholder('-'),
                TextEntry::make('facebook_url')
                    ->placeholder('-'),
                TextEntry::make('pinterest_url')
                    ->placeholder('-'),
                TextEntry::make('map_embed_code')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('faq_section_title')
                    ->placeholder('-'),
                TextEntry::make('faq_section_subtitle')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('cta_section_title')
                    ->placeholder('-'),
                TextEntry::make('cta_section_content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('cta_button_text'),
                TextEntry::make('cta_button_link'),
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
                    ->visible(fn (ContactPage $record): bool => $record->trashed()),
            ]);
    }
}
