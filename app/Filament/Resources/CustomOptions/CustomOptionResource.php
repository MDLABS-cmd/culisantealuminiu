<?php

namespace App\Filament\Resources\CustomOptions;

use App\Filament\Resources\CustomOptions\Pages\CreateCustomOption;
use App\Filament\Resources\CustomOptions\Pages\EditCustomOption;
use App\Filament\Resources\CustomOptions\Pages\ListCustomOptions;
use App\Filament\Resources\CustomOptions\Schemas\CustomOptionForm;
use App\Filament\Resources\CustomOptions\Tables\CustomOptionsTable;
use App\Models\CustomOption;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CustomOptionResource extends Resource
{
    protected static ?string $model = CustomOption::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'opțiune personalizată';

    protected static ?string $pluralModelLabel = 'opțiuni personalizate';

    public static function form(Schema $schema): Schema
    {
        return CustomOptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomOptionsTable::configure($table);
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
            'index' => ListCustomOptions::route('/'),
            'create' => CreateCustomOption::route('/create'),
            'edit' => EditCustomOption::route('/{record}/edit'),
        ];
    }
}
