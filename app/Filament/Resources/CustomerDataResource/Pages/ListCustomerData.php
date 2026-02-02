<?php

namespace App\Filament\Resources\CustomerDataResource\Pages;

use App\Filament\Resources\CustomerDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerData extends ListRecords
{
    protected static string $resource = CustomerDataResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}