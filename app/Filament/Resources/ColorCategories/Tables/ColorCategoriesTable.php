<?php

namespace App\Filament\Resources\ColorCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class ColorCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with('colors'))
            ->columns([
                TextColumn::make('name')
                    ->label('Nume')
                    ->searchable(),
                ViewColumn::make('colors_preview')
                    ->label('Culori')
                    ->view('filament.tables.columns.colors-preview'),
                IconColumn::make('active')
                    ->label('Activ')
                    ->boolean(),
                TextColumn::make('order')
                    ->label('Ordine')
                    ->numeric()
                    ->sortable(),
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
