<?php

namespace App\Filament\Resources\AboutPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AboutPageForm
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
                TextInput::make('section1_title')
                    ->required(),
                Textarea::make('section1_content')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('section1_image')
                    ->image(),
                TextInput::make('section2_title'),
                Textarea::make('section2_content')
                    ->columnSpanFull(),
                FileUpload::make('section2_image')
                    ->image(),
                TextInput::make('mission_title'),
                Textarea::make('mission_content')
                    ->columnSpanFull(),
                TextInput::make('vision_title'),
                Textarea::make('vision_content')
                    ->columnSpanFull(),
                TextInput::make('team_section_title'),
                Textarea::make('team_section_subtitle')
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
