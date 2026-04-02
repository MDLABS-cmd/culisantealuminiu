<?php

namespace App\Filament\Resources\Schemas\Schemas;

use App\Enums\SchemaPriceTypeEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SchemaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('system_id')
                    ->relationship('system', 'name')
                    ->required()
                    ->preload(),
                TextInput::make('name')
                    ->required(),
                Select::make('price_type')
                    ->options(SchemaPriceTypeEnum::options())
                    ->required(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('active')
                    ->required(),

                Repeater::make('dimensions')
                    ->relationship()
                    ->schema([
                        TextInput::make('width')
                            ->label('Width')
                            ->numeric()
                            ->required(),
                        TextInput::make('height')
                            ->label('Height')
                            ->numeric()
                            ->required(),
                        Toggle::make('active')
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->addActionLabel('Add Dimension'),
            ]);
    }
}
