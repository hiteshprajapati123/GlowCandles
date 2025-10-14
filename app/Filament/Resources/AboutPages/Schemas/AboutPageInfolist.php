<?php

namespace App\Filament\Resources\AboutPages\Schemas;

use App\Models\AboutPage;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AboutPageInfolist
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
                TextEntry::make('section1_title'),
                TextEntry::make('section1_content')
                    ->columnSpanFull(),
                ImageEntry::make('section1_image')
                    ->placeholder('-'),
                TextEntry::make('section2_title')
                    ->placeholder('-'),
                TextEntry::make('section2_content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('section2_image')
                    ->placeholder('-'),
                TextEntry::make('mission_title')
                    ->placeholder('-'),
                TextEntry::make('mission_content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('vision_title')
                    ->placeholder('-'),
                TextEntry::make('vision_content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('team_section_title')
                    ->placeholder('-'),
                TextEntry::make('team_section_subtitle')
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
                    ->visible(fn (AboutPage $record): bool => $record->trashed()),
            ]);
    }
}
