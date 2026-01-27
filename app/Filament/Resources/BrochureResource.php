<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Brochure;
use Filament\Forms\Form;
use App\Models\Residence;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BrochureResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BrochureResource\RelationManagers;

class BrochureResource extends Resource
{
    protected static ?string $model = Brochure::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('residence_id')
                    ->label('Residence')
                    ->relationship('residence', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull()
                    // ✅ hanya tampilkan residence yang belum punya brochure
                    ->options(function ($record) {
                        return Residence::whereDoesntHave('brochure')
                            ->orWhere('id', $record?->residence_id)
                            ->pluck('name', 'id');
                    }),

                    // ✅ validasi unique di Filament
                    // ->unique(
                    //     table: Brochure::class,
                    //     column: 'residence_id',
                    //     ignorable: fn ($record) => $record
                    // ),

                    // ✅ optional: saat edit tidak bisa ganti residence
                    // ->disabled(fn ($record) => $record !== null),

                FileUpload::make('file')
                    ->label('Brochure (PDF)')
                    ->required()
                    ->acceptedFileTypes(['application/pdf']) // ✅ hanya PDF
                    ->directory('brochures')                  // ✅ storage/app/public/brochures
                    ->disk('public')                          // ✅ pakai storage public
                    // ->maxSize(10240)                           // ✅ 10MB (opsional)
                    ->openable()                               // ✅ bisa dibuka di admin
                    ->downloadable()                          // ✅ bisa download di admin
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([

                TextColumn::make('residence.name')
                    ->label('Residence')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('file')
                    ->label('File')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created at')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrochures::route('/'),
            'create' => Pages\CreateBrochure::route('/create'),
            'view' => Pages\ViewBrochure::route('/{record}'),
            'edit' => Pages\EditBrochure::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}