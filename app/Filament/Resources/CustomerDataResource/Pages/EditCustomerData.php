<?php

namespace App\Filament\Resources\CustomerDataResource\Pages;

use App\Filament\Resources\CustomerDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerData extends EditRecord
{
    protected static string $resource = CustomerDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
