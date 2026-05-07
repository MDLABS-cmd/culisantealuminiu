<?php

namespace App\Filament\Resources\ConfiguratorSubmissions\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ConfiguratorSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with([
                'customer',
                'system',
                'schema',
                'dimension',
                'handle',
                'color',
            ]))
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tip')
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Stare')
                    ->badge()
                    ->sortable(),
                TextColumn::make('customer.first_name')
                    ->label('Client')
                    ->formatStateUsing(fn($state, $record) => trim("{$record->customer?->first_name} {$record->customer?->last_name}"))
                    ->searchable(query: function ($query, string $search): void {
                        $query->whereHas('customer', function ($customerQuery) use ($search): void {
                            $customerQuery
                                ->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                    }),
                TextColumn::make('customer.email')
                    ->label('Email')
                    ->toggleable(),
                TextColumn::make('system.name')
                    ->label('Sistem')
                    ->toggleable(),
                TextColumn::make('schema.name')
                    ->label('Schemă')
                    ->toggleable(),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('RON', divideBy: 1)
                    ->sortable(),
                TextColumn::make('submitted_at')
                    ->label('Trimis')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
