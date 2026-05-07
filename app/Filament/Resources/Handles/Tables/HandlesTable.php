<?php

namespace App\Filament\Resources\Handles\Tables;

use App\Enums\HandleTypeEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class HandlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nume')
                    ->searchable(),
                SelectColumn::make('type')
                    ->label('Tip')
                    ->options(HandleTypeEnum::options()),
                TextColumn::make('price')
                    ->label('Preț')
                    ->sortable(),
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
