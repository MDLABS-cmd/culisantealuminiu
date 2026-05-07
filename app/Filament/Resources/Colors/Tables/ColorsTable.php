<?php

namespace App\Filament\Resources\Colors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class ColorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with('category'))
            ->columns([
                TextColumn::make('category.name')
                    ->label('Categorie')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nume')
                    ->searchable(),
                ViewColumn::make('hex_code')
                    ->label('Culoare')
                    ->view('filament.tables.columns.color-swatch'),
                TextColumn::make('code')
                    ->label('Cod')
                    ->searchable(),
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
