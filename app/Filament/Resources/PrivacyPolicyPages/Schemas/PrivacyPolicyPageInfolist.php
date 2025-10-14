<?php

namespace App\Filament\Resources\PrivacyPolicyPages\Schemas;

use App\Models\PrivacyPolicyPage;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PrivacyPolicyPageInfolist
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
                TextEntry::make('introduction_title'),
                TextEntry::make('introduction_content')
                    ->columnSpanFull(),
                TextEntry::make('information_collection_title'),
                TextEntry::make('information_collection_content')
                    ->columnSpanFull(),
                TextEntry::make('how_we_use_title'),
                TextEntry::make('how_we_use_content')
                    ->columnSpanFull(),
                TextEntry::make('information_sharing_title'),
                TextEntry::make('information_sharing_content')
                    ->columnSpanFull(),
                TextEntry::make('data_security_title'),
                TextEntry::make('data_security_content')
                    ->columnSpanFull(),
                TextEntry::make('your_rights_title'),
                TextEntry::make('your_rights_content')
                    ->columnSpanFull(),
                TextEntry::make('cookies_title')
                    ->placeholder('-'),
                TextEntry::make('cookies_content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('third_party_links_title')
                    ->placeholder('-'),
                TextEntry::make('third_party_links_content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('children_privacy_title')
                    ->placeholder('-'),
                TextEntry::make('children_privacy_content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('policy_changes_title')
                    ->placeholder('-'),
                TextEntry::make('policy_changes_content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('contact_us_title')
                    ->placeholder('-'),
                TextEntry::make('contact_us_content')
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
                    ->visible(fn (PrivacyPolicyPage $record): bool => $record->trashed()),
            ]);
    }
}
