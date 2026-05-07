<?php

namespace App\Filament\Resources\Handles\Schemas;

use App\Enums\HandleTypeEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class HandleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nume')
                    ->required(),
                Select::make('type')
                    ->label('Tip')
                    ->required()
                    ->options(HandleTypeEnum::options()),
                TextInput::make('price')
                    ->label('Preț')
                    ->required()
                    ->numeric(),
                Toggle::make('active')
                    ->label('Activ')
                    ->required(),
            ]);
    }
}
