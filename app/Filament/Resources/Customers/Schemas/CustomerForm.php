<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Utilizator')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('company_name')
                    ->label('Nume companie')
                    ->maxLength(255),
                TextInput::make('first_name')
                    ->label('Prenume')
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->label('Nume')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Adresă de email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Număr de telefon')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                TextInput::make('address')
                    ->label('Adresă')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
