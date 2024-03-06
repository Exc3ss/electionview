<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionResource\Pages;
//use App\Filament\Resources\SectionResource\RelationManagers;
use App\Models\City;
use App\Models\Province;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Components\Fieldset;
use Closure;
//use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\SoftDeletingScope;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;
    protected static ?string $modelLabel = 'Sezione';
    protected static ?string $pluralModelLabel = 'Sezioni';
    //protected static ?string $navigationGroup = 'Sezioni';
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Sezione')
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
                        ->required(),
                    Forms\Components\TextInput::make('numero')
                        ->label('Sezione')
                        ->required()
                        ->numeric()
                        ->unique('sections', 'numero', null, 'id', function (Get $get, $rule) {
                            return $rule->where('comune_id', $get('comune_id'));
                        }),
                ])->columns(3),

                Fieldset::make('Dati Generali')
                    ->schema([
                        Forms\Components\TextInput::make('aventidiritto')
                            ->label('Aventi Diritto')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('votanti')
                            ->label('Votanti')
                            ->required()
                            ->numeric()
                            ->rules([
                                fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                    $tot = $get('schedebianche')+$get('schedenulle');
                                    if ($tot > $value ) {
                                        $fail("Hai inserito un numero di Votanti inferiore alla somma delle schede bianche e schede nulle.");
                                    }
                                },
                            ]),
                        Forms\Components\TextInput::make('schedebianche')
                            ->label('Schede Bianche')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('schedenulle')
                            ->label('Schede Nulle')
                            ->required()
                            ->numeric(),
                    ])->columns(4),

                Fieldset::make('Coalizione Centrosinistra')
                    ->schema([
                        Fieldset::make('Voti Presidente')
                            ->schema([
                                Forms\Components\TextInput::make('damico')
                                    ->label('Luciano D\'Amico')
                                    ->required()
                                    ->numeric(),
                            ]),
                        Fieldset::make('Voti Liste Centrosinistra')
                            ->schema([
                                Forms\Components\TextInput::make('pd')
                                    ->label('Partito Democratico')
                                    ->required()
                                    ->numeric(),
                                Forms\Components\TextInput::make('m5s')
                                    ->label('MoVimento 5 Stelle')
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
                                    ->label('Civici e Riformisti')
                                    ->required()
                                    ->numeric(),
                            ])->columns(6),
                    ]),

                Fieldset::make('Coalizione Centrodestra')
                    ->schema([
                        Fieldset::make('Voti Presidente')
                            ->schema([
                                Forms\Components\TextInput::make('marsilio')
                                    ->label('Marco Marsilio')
                                    ->required()
                                    ->numeric(),
                            ]),
                        Fieldset::make('Voti Liste Centrodestra')
                            ->schema([
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
                                    ->label('Marsilio Presidente')
                                    ->required()
                                    ->numeric(),
                            ])->columns(6),
                    ]),

                /*Forms\Components\Select::make('provincia_id')
                    ->label('Provincia')
                    ->options(Province::whereRegionId(13)->pluck('name','id'))
                    ->live()
                    ->required(),
                Forms\Components\Select::make('comune_id')
                    ->label('Comune')
                    ->options(fn(Forms\Get $get)=>City::where('province_id',(int)$get('provincia_id'))->pluck('name','id'))
                    ->disabled(fn(Forms\Get $get) : bool => ($get('comune_id') == null &&  $get('provincia_id') == null))
                    //->afterStateUpdated(fn (Forms\Set $set) => $set('comune_id', 0))
                    ->required(),
                Forms\Components\TextInput::make('numero')
                    ->label('Sezione')
                    ->required()
                    ->numeric()
                    ->unique('sections', 'numero', null, 'id', function (Get $get, $rule) {
                        return $rule->where('comune_id', $get('comune_id'));
                    }),
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
                    ->numeric(),*/
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero')
                    ->label('Sezione')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('city.name')
                    ->label('Comune')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('province.name')
                    ->label('Provincia')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('damico')
                    ->label('Voti D\'Amico')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('marsilio')
                    ->label('Voti Marsilio')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Inserito il')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modificato il')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton()->label('Modifica'),
                Tables\Actions\DeleteAction::make()->iconButton()->label('Cancella'),
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
