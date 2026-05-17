<?php

namespace App\Filament\Resources\Schemas\Schemas;

use App\Enums\SchemaPriceTypeEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SchemaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('system_id')
                    ->label('Sistem')
                    ->relationship('system', 'name')
                    ->required()
                    ->preload(),
                Select::make('material_id')
                    ->label('Material')
                    ->relationship('material', 'name')
                    ->required()
                    ->preload(),
                TextInput::make('name')
                    ->label('Nume')
                    ->required(),
                FileUpload::make('image')
                    ->label('Imagine')
                    ->image()
                    ->disk('public')
                    ->directory('schemas')
                    ->visibility('public')
                    ->storeFiles(false)
                    ->nullable(),
                Select::make('price_type')
                    ->label('Tip preț')
                    ->options(SchemaPriceTypeEnum::options())
                    ->required(),
                TextInput::make('order')
                    ->label('Ordine')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('active')
                    ->label('Activ')
                    ->default(true)
                    ->required(),

                Repeater::make('dimensions')
                    ->label('Dimensiuni')
                    ->relationship()
                    ->schema([
                        TextInput::make('width')
                            ->label('Lățime')
                            ->numeric()
                            ->required(),
                        TextInput::make('height')
                            ->label('Înălțime')
                            ->numeric()
                            ->required(),
                        Toggle::make('active')
                            ->label('Activ')
                            ->default(true)
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->addActionLabel('Adaugă dimensiune'),
            ]);
    }
}
