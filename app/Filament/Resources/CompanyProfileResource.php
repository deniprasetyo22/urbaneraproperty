<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CompanyProfile;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CompanyProfileResource\Pages;
use App\Filament\Resources\CompanyProfileResource\RelationManagers;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class CompanyProfileResource extends Resource
{
    protected static ?string $model = CompanyProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                RichEditor::make('about')
                    ->label('About')
                    ->placeholder('About')
                    ->columnSpanFull()
                    ->autofocus()
                    ->required(),

                RichEditor::make('vision')
                    ->label('Vision')
                    ->placeholder('Vision')
                    ->columnSpanFull()
                    ->required(),

                RichEditor::make('mission')
                    ->label('Mission')
                    ->placeholder('Mission')
                    ->columnSpanFull()
                    ->required(),

                FileUpload::make('video')
                    ->label('Video')
                    ->acceptedFileTypes(['video/*'])
                    ->directory('videos')
                    ->disk('public')
                    ->maxSize(102400)
                    ->columnSpanFull()
                    ->required(),

                Section::make('Achievements')
                    ->schema([
                        Repeater::make('achievements')
                            ->label('Achievements')
                            ->schema([
                                RichEditor::make('description')
                                    ->label('Description')
                                    ->placeholder('Description')
                                    ->required(),

                                FileUpload::make('image')
                                    ->label('Image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('achievements')
                                    ->required(),
                            ])
                            ->columnSpanFull()
                            ->addActionLabel('Add Achievement')
                            ->required(),
                    ]),

                Section::make('Portfolio')
                    ->schema([
                        Repeater::make('portfolio')
                            ->label('Portfolio')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required(),

                                RichEditor::make('description')
                                    ->label('Description')
                                    ->placeholder('Description')
                                    ->required(),

                                FileUpload::make('image')
                                    ->label('Image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('portfolio')
                                    ->required(),
                            ])
                            ->columnSpanFull()
                            ->addActionLabel('Add Portfolio')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('about')
                    ->label('About')
                    ->limit(50) // ✅ max 50 karakter di table
                    ->html()    // karena dari RichEditor
                    ->wrap()
                    ->tooltip(fn($record) => strip_tags($record->about)),

                TextColumn::make('vision')
                    ->label('Vision')
                    ->limit(40)
                    ->html()
                    ->wrap()
                    ->tooltip(fn($record) => strip_tags($record->vision)),

                TextColumn::make('mission')
                    ->label('Mission')
                    ->limit(40)
                    ->html()
                    ->wrap()
                    ->tooltip(fn($record) => strip_tags($record->mission)),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListCompanyProfiles::route('/'),
            'create' => Pages\CreateCompanyProfile::route('/create'),
            'view' => Pages\ViewCompanyProfile::route('/{record}'),
            'edit' => Pages\EditCompanyProfile::route('/{record}/edit'),
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