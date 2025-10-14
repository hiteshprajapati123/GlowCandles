<?php

namespace App\Filament\Resources\ShippingPolicyPages\Pages;

use App\Filament\Resources\ShippingPolicyPages\ShippingPolicyPageResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditShippingPolicyPage extends EditRecord
{
    protected static string $resource = ShippingPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
