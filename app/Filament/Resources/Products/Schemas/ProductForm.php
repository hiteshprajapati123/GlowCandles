<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug'),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('₹'),
                TextInput::make('sku')
                    ->label('SKU'),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('track_quantity')
                    ->required(),
                Select::make('type')
                    ->options(['simple' => 'Simple', 'variable' => 'Variable', 'digital' => 'Digital', 'service' => 'Service'])
                    ->default('simple')
                    ->required(),
                Select::make('status')
                    ->options(['draft' => 'Draft', 'active' => 'Active', 'archived' => 'Archived'])
                    ->default('draft')
                    ->required(),
                FileUpload::make('main_image')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->visibility('public')
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1'])
                    ->imageResizeTargetWidth('300')
                    ->imageResizeTargetHeight('300')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imagePreviewHeight('100')
                    ->panelLayout('compact')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('center')
                    ->uploadProgressIndicatorPosition('right')
                    ->required()
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/*'])
                    ->getUploadedFileNameForStorageUsing(
                        fn ($file): string => 'products/' . uniqid() . '.' . $file->getClientOriginalExtension(),
                    )
                    ->columnSpanFull()
                    ->extraAttributes(['class' => 'max-w-xs'])
                    ->label('')
                    ->hint('Click to upload or drag and drop')
                    ->hintIcon('heroicon-m-photo')
                    ->columnSpan(1),
                Select::make('category_id')
                    ->label('Category')
                    ->options(function () {
                        $categories = Category::with('children')
                            ->whereNull('parent_id')
                            ->get();
                        
                        $options = [];
                        
                        foreach ($categories as $category) {
                            if ($category->children->isNotEmpty()) {
                                $options[$category->name] = $category->children->pluck('name', 'id')->toArray();
                            } else {
                                $options[$category->name] = [$category->id => $category->name];
                            }
                        }
                        
                        return $options;
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->relationship('category', 'name'),
                TextInput::make('brand'),
                TagsInput::make('tags')
                    ->separator(',')
                    ->suggestions([
                        'featured',
                        'new-arrival',
                        'best-seller',
                        'sale',
                    ]),
                TextInput::make('meta_title'),
                Textarea::make('meta_description')
                    ->columnSpanFull(),
                TextInput::make('meta_keywords'),
                Toggle::make('is_new')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
