<?php

namespace App\Filament\Resources\Systems\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SystemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nume')
                    ->required(),
                TextInput::make('display_name')
                    ->label('Nume afișat')
                    ->required(),
                Toggle::make('is_custom')
                    ->label('Personalizat')
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

                Select::make('colorCategories')
                    ->label('Categorii de culori')
                    ->relationship('colorCategories', 'name')
                    ->multiple()
                    ->preload(),
            ]);
    }
}
