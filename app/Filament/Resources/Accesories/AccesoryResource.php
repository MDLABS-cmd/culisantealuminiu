<?php

namespace App\Filament\Resources\Accesories;

use App\Filament\Resources\Accesories\Pages\CreateAccesory;
use App\Filament\Resources\Accesories\Pages\EditAccesory;
use App\Filament\Resources\Accesories\Pages\ListAccesories;
use App\Filament\Resources\Accesories\Schemas\AccesoryForm;
use App\Filament\Resources\Accesories\Tables\AccesoriesTable;
use App\Models\Accesory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AccesoryResource extends Resource
{
    protected static ?string $model = Accesory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AccesoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AccesoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAccesories::route('/'),
            'create' => CreateAccesory::route('/create'),
            'edit' => EditAccesory::route('/{record}/edit'),
        ];
    }
}
