<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Residence;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use function Pest\Laravel\get;
use Filament\Resources\Resource;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ResidenceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ResidenceResource\RelationManagers;

class ResidenceResource extends Resource
{
    protected static ?string $model = Residence::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Residence Name')
                    ->autofocus()
                    ->placeholder('Residence Name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->unique(ignoreRecord: true)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        if (!$get('slug')) {
                            $set('slug', Str::slug($state));
                        }
                    }),

                Forms\Components\Select::make('province_id')
                    ->label('Province')
                    ->searchable()
                    ->options(function () {
                        return Cache::remember('provinces_list', 60 * 24, function () {
                            $response = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json');
                            if ($response->successful()) {
                                return collect($response->json())->mapWithKeys(fn($prov) => [
                                    $prov['id'] => $prov['name']
                                ])->toArray();
                            }
                            return [];
                        });
                    })
                    ->reactive()
                    ->required(),

                Forms\Components\Select::make('city')
                    ->label('Regency')
                    ->searchable()
                    ->options(function (callable $get) {
                        $provinceId = $get('province_id');
                        if (!$provinceId) {
                            return [];
                        }

                        return Cache::remember("regencies_for_{$provinceId}", 60 * 24, function () use ($provinceId) {
                            $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$provinceId}.json");
                            if ($response->successful()) {
                                return collect($response->json())->mapWithKeys(fn($kab) => [
                                    $kab['name'] => $kab['name']
                                ])->toArray();
                            }
                            return [];
                        });
                    })
                    ->reactive()
                    ->required(),

                Forms\Components\FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->directory('residences')
                    ->disk('public')
                    ->imagePreviewHeight('200')
                    // ->maxSize(2048) // 2MB
                    ->columnSpanFull()
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->defaultSort('created_at', 'desc')
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('city')
                ->label('Location')
                ->searchable()
                ->sortable(),
            Tables\Columns\ImageColumn::make('image'),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime('d M Y H:i')
                ->sortable(),
            Tables\Columns\TextColumn::make('deleted_at')
                ->dateTime()
                ->toggleable(isToggledHiddenByDefault: true),
        ])

        ->filters([
            Tables\Filters\TrashedFilter::make(),
        ])

        ->actions([
            Tables\Actions\ActionGroup::make([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ]),
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
            'index' => Pages\ListResidences::route('/'),
            'create' => Pages\CreateResidence::route('/create'),
            'view' => Pages\ViewResidence::route('/{record}'),
            'edit' => Pages\EditResidence::route('/{record}/edit'),
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