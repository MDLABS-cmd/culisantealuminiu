<?php

namespace App\Filament\Resources\ColorCategories\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ColorCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->columnSpanFull()
                    ->required(),
                Toggle::make('active')
                    ->required(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),

                Repeater::make('colors')
                    ->relationship()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('hex_code')
                            ->required()
                            ->label('Hex Code'),
                        TextInput::make('code')
                            ->required()
                            ->label('Code'),
                        Toggle::make('active')
                            ->required(),
                    ])
                    ->addActionLabel('Add Color')
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}
