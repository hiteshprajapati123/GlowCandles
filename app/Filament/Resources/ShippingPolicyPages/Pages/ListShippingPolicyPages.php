<?php

namespace App\Filament\Resources\ShippingPolicyPages\Pages;

use App\Filament\Resources\ShippingPolicyPages\ShippingPolicyPageResource;
use Filament\Resources\Pages\ListRecords;

class ListShippingPolicyPages extends ListRecords
{
    protected static string $resource = ShippingPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
