<?php

namespace App\Filament\Resources\CustomOptions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CustomOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nume')
                    ->required(),
                Toggle::make('active')
                    ->label('Activ')
                    ->default(true)
                    ->required(),
            ]);
    }
}
