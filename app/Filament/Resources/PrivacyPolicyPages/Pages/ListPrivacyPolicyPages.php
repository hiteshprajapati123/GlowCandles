<?php

namespace App\Filament\Resources\PrivacyPolicyPages\Pages;

use App\Filament\Resources\PrivacyPolicyPages\PrivacyPolicyPageResource;
use Filament\Resources\Pages\ListRecords;

class ListPrivacyPolicyPages extends ListRecords
{
    protected static string $resource = PrivacyPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
