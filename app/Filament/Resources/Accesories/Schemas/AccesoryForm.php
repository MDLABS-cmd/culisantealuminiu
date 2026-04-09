<?php

namespace App\Filament\Resources\Accesories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AccesoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric(),
                Toggle::make('active')
                    ->required(),
                Select::make('schemas')
                    ->label('Schemas')
                    ->multiple()
                    ->relationship('schemas', 'name')
                    ->preload(),
            ]);
    }
}
