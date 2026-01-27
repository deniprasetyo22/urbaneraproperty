<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Property;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PropertyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PropertyResource\RelationManagers;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Basic Information')
                ->schema([

                    Forms\Components\Select::make('residence_id')
                        ->label('Residence')
                        ->relationship('residence', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Forms\Components\TextInput::make('name')
                        ->label('Property Name')
                        ->placeholder('Property Name')
                        ->required()
                        ->maxLength(255)
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            if (! $get('slug')) {
                                $set('slug', Str::slug($state));
                            }
                        }),

                    Forms\Components\TextInput::make('type')
                        ->placeholder('Property Type')
                        ->required()
                        ->numeric()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->label('Price')
                            ->prefix('Rp')
                            ->live(onBlur: false)
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === null) return;

                                // Ambil angka saja
                                $number = preg_replace('/\D/', '', (string) $state);

                                if ($number === '') {
                                    $set('price', null);
                                    return;
                                }

                                // Format ribuan
                                $formatted = number_format((float) $number, 0, ',', '.');

                                $set('price', $formatted);
                            })
                            ->dehydrateStateUsing(function ($state) {
                                $number = preg_replace('/\D/', '', (string) $state);
                                return $number === '' ? null : $number;
                            })
                            ->placeholder('0')
                            ->required(),

                    Forms\Components\RichEditor::make('description')
                        ->placeholder('Description')
                        ->columnSpanFull()
                        ->required(),

                ])->columns(2),

            Forms\Components\Section::make('Location & Address')
                ->schema([

                    Forms\Components\Textarea::make('property_address')
                        ->placeholder('Jalan, No., RT/RW, Kelurahan, Kecamatan, Kota, Provinsi')
                        ->rows(3)
                        ->columnSpanFull()
                        ->required(),

                    Forms\Components\Textarea::make('map')
                        ->placeholder('Google Maps Embed <iframe>')
                        ->label('Google Maps Embed Link')
                        ->rows(3)
                        ->columnSpanFull()
                        ->required(),

                ]),

            Forms\Components\Section::make('Nearby & Details')
                ->schema([

                    Forms\Components\RichEditor::make('nearby_amenities')
                        ->label('Nearby Amenities')
                        ->placeholder('Nearby Amenities')
                        ->required(),

                    Forms\Components\Repeater::make('property_details')
                        ->label('Property Details')
                        ->required()
                        ->schema([
                            Forms\Components\TextInput::make('label')
                                ->disabled()
                                ->dehydrated() // tetap disimpan ke DB walau disabled
                                ->required(),

                            Forms\Components\TextInput::make('value')
                                ->required(),
                        ])
                        ->columns(2)
                        ->default([
                            ['label' => 'Property Size', 'value' => null],
                            ['label' => 'Year Build', 'value' => null],
                            ['label' => 'Bedrooms', 'value' => null],
                            ['label' => 'Bathrooms', 'value' => null],
                            ['label' => 'Garage', 'value' => null],
                        ])
                        ->addable(false)    // ❌ tidak bisa tambah
                        ->deletable(false) // ❌ tidak bisa hapus
                        ->reorderable(false),

                    Forms\Components\CheckboxList::make('property_features')
                    ->label('Features')
                    ->options([
                        'Air Condition' => '❄️ Air Condition',
                        'Carport'       => '🚗 Carport',
                        'Swimming Pool' => '🏊 Swimming Pool',
                        'Balcony'       => '🏢 Balcony',
                        'Rooftop'       => '🏠 Rooftop',
                        'Security 24/7' => '🛡️ Security 24/7',
                        'Gym'           => '🏋️ Gym',
                        'Garden'        => '🌿 Garden',
                        'Wifi'          => '📶 WiFi Ready',
                        'Cctv'          => '📹 CCTV',
                    ])
                    ->columns(3)
                    ->bulkToggleable()

                ]),

            Forms\Components\Section::make('Images & Videos')
                ->schema([
                    Forms\Components\FileUpload::make('media')
                        ->label('Images & Videos')
                        ->multiple()
                        ->acceptedFileTypes(['image/*', 'video/*'])
                        // ->maxSize(50 * 1024) // Contoh: 50MB
                        ->reorderable()
                        ->directory('properties/iamgesAndVideos')
                        ->disk('public')
                        ->required()
                        ->panelLayout('grid')
                        ->openable(),
                ]),

            Forms\Components\Section::make('Floor Plan')
                ->schema([
                    Forms\Components\FileUpload::make('floor_plan')
                        ->multiple()
                        ->image()
                        ->reorderable()
                        ->directory('properties/floor-plan')
                        ->disk('public')
                        ->required()
                        ->panelLayout('grid')
                        ->openable(),
                ]),

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

                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('residence.name')
                    ->label('Residence')
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('IDR', true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'view' => Pages\ViewProperty::route('/{record}'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
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