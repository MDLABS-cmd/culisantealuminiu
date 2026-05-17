<?php

namespace App\Filament\Resources\ColorCategories\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ColorCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nume')
                    ->columnSpanFull()
                    ->required(),
                Toggle::make('active')
                    ->label('Activ')
                    ->default(true)
                    ->required(),
                TextInput::make('order')
                    ->label('Ordine')
                    ->required()
                    ->numeric()
                    ->default(0),

                Repeater::make('colors')
                    ->label('Culori')
                    ->relationship()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nume')
                            ->required(),
                        TextInput::make('hex_code')
                            ->required()
                            ->label('Cod Hex'),
                        TextInput::make('code')
                            ->required()
                            ->label('Cod'),
                        Toggle::make('active')
                            ->label('Activ')
                            ->required(),
                    ])
                    ->addActionLabel('Adaugă culoare')
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}
