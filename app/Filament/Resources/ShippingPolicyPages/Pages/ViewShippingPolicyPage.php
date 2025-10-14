<?php

namespace App\Filament\Resources\ShippingPolicyPages\Pages;

use App\Filament\Resources\ShippingPolicyPages\ShippingPolicyPageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewShippingPolicyPage extends ViewRecord
{
    protected static string $resource = ShippingPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
