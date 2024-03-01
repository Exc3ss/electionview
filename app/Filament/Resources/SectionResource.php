<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionResource\Pages;
use App\Filament\Resources\SectionResource\RelationManagers;
use App\Models\City;
use App\Models\Province;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('provincia_id')
                    ->label('Provincia')
                    ->options(Province::whereRegionId(13)->pluck('name','id'))
                    ->live()
                    ->required(),
                Forms\Components\Select::make('comune_id')
                    ->label('Comune')
                    ->options(fn(Forms\Get $get)=>City::where('province_id',(int)$get('provincia_id'))->pluck('name','id'))
                    ->disabled(fn(Forms\Get $get) : bool => ($get('comune_id') == null &&  $get('provincia_id') == null))
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('comune_id', 0))
                    ->required(),

                Forms\Components\TextInput::make('numero')
                    ->label('Sezione')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('schedebianche')
                    ->label('Schede Bianche')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('schedenulle')
                    ->label('Schede Nulle')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('aventidiritto')
                    ->label('Aventi Diritto')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('votanti')
                    ->label('Votanti')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('damico')
                    ->label('Luciano D\'Amico')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('m5s')
                    ->label('MoVimento 5 Stelle')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pd')
                    ->label('Partito Democratico')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('azione')
                    ->label('Azione')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('verdisi')
                    ->label('Verdi - Sinistra Italiana')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('abruzzoinsieme')
                    ->label('Abruzzo Insieme')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('damicopresidente')
                    ->label('D\'Amico Presidente - Civici e Riformisti')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('marsilio')
                    ->label('Marco Marsilio')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('fdi')
                    ->label('Fratelli D\'Italia')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('lega')
                    ->label('Lega Nord')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('forzaitalia')
                    ->label('Forza Italia')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('noimoderati')
                    ->label('Noi Moderati')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('unionedicentro')
                    ->label('Unione di Centro')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('marsiliopresidente')
                    ->required()
                    ->numeric(),


            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('schedebianche')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('schedenulle')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('aventidiritto')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('votanti')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('damico')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('m5s')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pd')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('azione')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('verdisi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('abruzzoinsieme')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('damicopresidente')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('marsilio')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fdi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lega')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('forzaitalia')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('noimoderati')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unionedicentro')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('marsiliopresidente')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('comune_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('provincia_id')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
