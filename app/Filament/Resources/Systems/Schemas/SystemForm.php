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
                    ->required(),
                Toggle::make('is_custom')
                    ->required(),
                Toggle::make('active')
                    ->required(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),

                Select::make('colorCategories')
                    ->relationship('colorCategories', 'name')
                    ->multiple()
                    ->preload(),
                Select::make('materials')
                    ->relationship('materials', 'name')
                    ->multiple()
                    ->preload(),
            ]);
    }
}
