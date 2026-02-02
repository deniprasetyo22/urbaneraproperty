<?php

namespace App\Filament\Resources\CustomerDataResource\Pages;

use App\Filament\Resources\CustomerDataResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerData extends CreateRecord
{
    protected static string $resource = CustomerDataResource::class;
}
