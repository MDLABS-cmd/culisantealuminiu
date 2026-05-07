<?php

namespace App\Filament\Resources\Catalogues;

use App\Filament\Resources\Catalogues\Pages\CreateCatalogue;
use App\Filament\Resources\Catalogues\Pages\EditCatalogue;
use App\Filament\Resources\Catalogues\Pages\ListCatalogues;
use App\Filament\Resources\Catalogues\Schemas\CatalogueForm;
use App\Filament\Resources\Catalogues\Tables\CataloguesTable;
use App\Models\Catalogue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatalogueResource extends Resource
{
    protected static ?string $model = Catalogue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $modelLabel = 'catalog';

    protected static ?string $pluralModelLabel = 'cataloage';

    public static function form(Schema $schema): Schema
    {
        return CatalogueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CataloguesTable::configure($table);
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
            'index' => ListCatalogues::route('/'),
            'create' => CreateCatalogue::route('/create'),
            'edit' => EditCatalogue::route('/{record}/edit'),
        ];
    }
}
