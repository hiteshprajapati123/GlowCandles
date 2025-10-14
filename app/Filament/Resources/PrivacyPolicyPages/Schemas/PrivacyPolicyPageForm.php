<?php

namespace App\Filament\Resources\PrivacyPolicyPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PrivacyPolicyPageForm
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
                TextInput::make('introduction_title')
                    ->required(),
                Textarea::make('introduction_content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('information_collection_title')
                    ->required(),
                Textarea::make('information_collection_content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('how_we_use_title')
                    ->required(),
                Textarea::make('how_we_use_content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('information_sharing_title')
                    ->required(),
                Textarea::make('information_sharing_content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('data_security_title')
                    ->required(),
                Textarea::make('data_security_content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('your_rights_title')
                    ->required(),
                Textarea::make('your_rights_content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('cookies_title'),
                Textarea::make('cookies_content')
                    ->columnSpanFull(),
                TextInput::make('third_party_links_title'),
                Textarea::make('third_party_links_content')
                    ->columnSpanFull(),
                TextInput::make('children_privacy_title'),
                Textarea::make('children_privacy_content')
                    ->columnSpanFull(),
                TextInput::make('policy_changes_title'),
                Textarea::make('policy_changes_content')
                    ->columnSpanFull(),
                TextInput::make('contact_us_title'),
                Textarea::make('contact_us_content')
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
