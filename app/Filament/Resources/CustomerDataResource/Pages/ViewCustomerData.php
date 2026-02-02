<?php

namespace App\Filament\Resources\CustomerDataResource\Pages;

use App\Filament\Resources\CustomerDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomerData extends ViewRecord
{
    protected static string $resource = CustomerDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
