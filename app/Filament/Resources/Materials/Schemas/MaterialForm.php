<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nume')
                ->required()
                ->columnSpanFull(),
            Toggle::make('active')
                ->label('Activ')
                ->required(),
            TextInput::make('order')
                ->label('Ordine')
                ->required()
                ->numeric()
                ->default(0),
        ]);
    }
}
