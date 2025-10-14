<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutPages\AboutPageResource;
use App\Filament\Resources\ContactPages\ContactPageResource;
use App\Filament\Resources\PrivacyPolicyPages\PrivacyPolicyPageResource;
use App\Filament\Resources\ShippingPolicyPages\ShippingPolicyPageResource;
use Filament\Resources\Resource;

class PageResource extends Resource
{
    public static function getNavigationLabel(): string
    {
        return 'Pages';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationGroup(): ?string
    {
        return null; // This will be the main navigation item
    }

    public static function getNavigationItems(): array
    {
        return [
            AboutPageResource::getNavigationItem()
                ->group('Pages')
                ->sort(1),
                
            ContactPageResource::getNavigationItem()
                ->group('Pages')
                ->sort(2),
                
            PrivacyPolicyPageResource::getNavigationItem()
                ->group('Pages')
                ->sort(3),
                
            ShippingPolicyPageResource::getNavigationItem()
                ->group('Pages')
                ->sort(4),
        ];
    }
}
