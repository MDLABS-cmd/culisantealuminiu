<?php

namespace App\Filament\Resources\Colors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ColorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('color_category_id')
                    ->label('ID Categorie')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->label('Nume')
                    ->required(),
                TextInput::make('hex_code')
                    ->label('Cod Hex')
                    ->required(),
                TextInput::make('code')
                    ->label('Cod')
                    ->required(),
                Toggle::make('active')
                    ->label('Activ')
                    ->required(),
                Select::make('colorCategories')
                    ->label('Categorii de culori')
                    ->relationship('colorCategories', 'name')
                    ->multiple()
                    ->preload(),
            ]);
    }
}
