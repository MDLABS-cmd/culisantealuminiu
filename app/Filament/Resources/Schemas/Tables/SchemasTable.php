<?php

namespace App\Filament\Resources\Schemas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class SchemasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with(['dimensions', 'files']))
            ->columns([
                TextColumn::make('name')
                    ->label('Nume'),
                TextColumn::make('price_type')
                    ->label('Tip preț'),
                ImageColumn::make('image')
                    ->label('Imagine')
                    ->getStateUsing(fn($record) => $record->getFirstFileUrl('image'))
                    ->imageSize(36),
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
