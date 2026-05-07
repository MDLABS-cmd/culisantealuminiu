<?php

namespace App\Filament\Resources\Catalogues\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CatalogueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Titlu')
                    ->required(),
                Textarea::make('description')
                    ->label('Descriere')
                    ->nullable()
                    ->columnSpanFull(),
                FileUpload::make('file')
                    ->label('Fișier PDF')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('public')
                    ->directory('catalogues')
                    ->visibility('public')
                    ->storeFiles(false)
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }
}
