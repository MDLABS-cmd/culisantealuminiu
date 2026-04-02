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
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('hex_code')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                Toggle::make('active')
                    ->required(),
                Select::make('colorCategories')
                    ->relationship('colorCategories', 'name')
                    ->multiple()
                    ->preload(),
            ]);
    }
}
