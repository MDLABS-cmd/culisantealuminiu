<?php

namespace App\Filament\Resources\Customers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Utilizator')
                    ->searchable(),
                TextColumn::make('company_name')
                    ->label('Nume companie')
                    ->searchable(),
                TextColumn::make('first_name')
                    ->label('Prenume')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('Nume')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Adresă de email')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Număr de telefon')
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Adresă')
                    ->searchable(),
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
