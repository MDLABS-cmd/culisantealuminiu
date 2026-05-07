<?php

namespace App\Filament\Resources\Dimensions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DimensionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('schema_id')
                    ->label('Schemă')
                    ->relationship('schema', 'name')
                    ->required()
                    ->preload(),
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
                    ->required(),
            ]);
    }
}
