<?php

namespace App\Filament\Resources\PrivacyPolicyPages\Pages;

use App\Filament\Resources\PrivacyPolicyPages\PrivacyPolicyPageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPrivacyPolicyPage extends ViewRecord
{
    protected static string $resource = PrivacyPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
