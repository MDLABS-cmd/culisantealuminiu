<?php

namespace App\Filament\Resources\Accesories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AccesoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with('schemas'))
            ->columns([
                TextColumn::make('name')
                    ->label('Nume')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Preț')
                    ->sortable(),
                TextColumn::make('schemas.name')
                    ->label('Scheme')
                    ->badge()
                    ->wrap(),
                IconColumn::make('active')
                    ->label('Activ')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Creat la')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizat la')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
