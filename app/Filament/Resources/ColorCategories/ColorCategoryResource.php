<?php

namespace App\Filament\Resources\ColorCategories;

use App\Filament\Resources\ColorCategories\Pages\CreateColorCategory;
use App\Filament\Resources\ColorCategories\Pages\EditColorCategory;
use App\Filament\Resources\ColorCategories\Pages\ListColorCategories;
use App\Filament\Resources\ColorCategories\Schemas\ColorCategoryForm;
use App\Filament\Resources\ColorCategories\Tables\ColorCategoriesTable;
use App\Models\ColorCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ColorCategoryResource extends Resource
{
    protected static ?string $model = ColorCategory::class;

    protected static ?string $modelLabel = 'categorie de culori';

    protected static ?string $pluralModelLabel = 'categorii de culori';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ColorCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ColorCategoriesTable::configure($table);
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
            'index' => ListColorCategories::route('/'),
            'create' => CreateColorCategory::route('/create'),
            'edit' => EditColorCategory::route('/{record}/edit'),
        ];
    }
}
