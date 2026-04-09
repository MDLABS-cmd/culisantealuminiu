<?php

namespace App\Filament\Resources\Handles;

use App\Filament\Resources\Handles\Pages\CreateHandle;
use App\Filament\Resources\Handles\Pages\EditHandle;
use App\Filament\Resources\Handles\Pages\ListHandles;
use App\Filament\Resources\Handles\Schemas\HandleForm;
use App\Filament\Resources\Handles\Tables\HandlesTable;
use App\Models\Handle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HandleResource extends Resource
{
    protected static ?string $model = Handle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return HandleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HandlesTable::configure($table);
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
            'index' => ListHandles::route('/'),
            'create' => CreateHandle::route('/create'),
            'edit' => EditHandle::route('/{record}/edit'),
        ];
    }
}
