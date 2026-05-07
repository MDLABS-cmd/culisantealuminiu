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
                    ->label('Nume')
                    ->required(),
                TextInput::make('price')
                    ->label('Preț')
                    ->required()
                    ->numeric(),
                Toggle::make('active')
                    ->label('Activ')
                    ->required(),
                Select::make('schemas')
                    ->label('Scheme')
                    ->multiple()
                    ->relationship('schemas', 'name')
                    ->preload(),
            ]);
    }
}
