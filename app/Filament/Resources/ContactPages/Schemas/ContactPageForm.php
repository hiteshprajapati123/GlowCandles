<?php

namespace App\Filament\Resources\ContactPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContactPageForm
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
                TextInput::make('contact_form_title')
                    ->required(),
                Textarea::make('contact_form_subtitle')
                    ->columnSpanFull(),
                TextInput::make('contact_info_title')
                    ->required(),
                Textarea::make('contact_info_subtitle')
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('business_hours_title'),
                Textarea::make('business_hours_content')
                    ->columnSpanFull(),
                TextInput::make('social_media_title'),
                Textarea::make('social_media_subtitle')
                    ->columnSpanFull(),
                TextInput::make('instagram_url')
                    ->url(),
                TextInput::make('facebook_url')
                    ->url(),
                TextInput::make('pinterest_url')
                    ->url(),
                Textarea::make('map_embed_code')
                    ->columnSpanFull(),
                TextInput::make('faq_section_title'),
                Textarea::make('faq_section_subtitle')
                    ->columnSpanFull(),
                TextInput::make('cta_section_title'),
                Textarea::make('cta_section_content')
                    ->columnSpanFull(),
                TextInput::make('cta_button_text')
                    ->required()
                    ->default('Shop Now'),
                TextInput::make('cta_button_link')
                    ->required()
                    ->default('/shop'),
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
