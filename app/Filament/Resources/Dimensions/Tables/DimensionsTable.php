<?php

namespace App\Filament\Resources\Dimensions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DimensionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with('schema'))
            ->columns([
                TextColumn::make('schema.name')
                    ->label('Schemă'),
                TextColumn::make('width')
                    ->label('Lățime'),
                TextColumn::make('height')
                    ->label('Înălțime'),
                IconColumn::make('active')
                    ->label('Activ')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
