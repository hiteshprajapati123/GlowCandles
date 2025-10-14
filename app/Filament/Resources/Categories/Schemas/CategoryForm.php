<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Featured Image')
                    ->image()
                    ->directory('categories')
                    ->visibility('public')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->imageResizeTargetWidth('1024')
                    ->imageResizeTargetHeight('1024')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imagePreviewHeight('250')
                    ->loadingIndicatorPosition('right')
                    ->panelAspectRatio('2:1')
                    ->panelLayout('integrated')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left')
                    ->columnSpanFull()
                    ->maxSize(10240)
                    ->acceptedFileTypes(['image/*'])
                    ->downloadable()
                    ->openable()
                    ->previewable()
                    ->disk('public')
                    ->getUploadedFileNameForStorageUsing(
                        fn ($file): string => uniqid() . '.' . $file->getClientOriginalExtension()
                    )
                    ->saveUploadedFileUsing(function ($file) {
                        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('categories', $filename, 'public');
                        return 'categories/' . $filename;
                    }),
                TextInput::make('icon'),
                TextInput::make('parent_id')
                    ->numeric(),
                TextInput::make('meta_title'),
                Textarea::make('meta_description')
                    ->columnSpanFull(),
                TextInput::make('position')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                TextInput::make('attributes'),
            ]);
    }
}
