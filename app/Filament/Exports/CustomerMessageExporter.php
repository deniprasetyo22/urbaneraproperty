<?php

namespace App\Filament\Exports;

use App\Models\Message;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CustomerMessageExporter extends Exporter
{
    protected static ?string $model = Message::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name'),
            ExportColumn::make('phone'),
            ExportColumn::make('message'),
            ExportColumn::make('created_at'),
        ];
    }

    public function getFileName(Export $export): string
    {
        return "customer-messages-" . now()->format('Y-m-d-His');
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your customer message export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }


}