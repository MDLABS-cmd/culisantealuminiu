<?php

namespace App\Filament\Resources\ConfiguratorSubmissions;

use App\Filament\Resources\ConfiguratorSubmissions\Pages\ListConfiguratorSubmissions;
use App\Filament\Resources\ConfiguratorSubmissions\Pages\ViewConfiguratorSubmission;
use App\Filament\Resources\ConfiguratorSubmissions\Tables\ConfiguratorSubmissionsTable;
use App\Models\ConfiguratorSubmission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ConfiguratorSubmissionResource extends Resource
{
    protected static ?string $model = ConfiguratorSubmission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function table(Table $table): Table
    {
        return ConfiguratorSubmissionsTable::configure($table);
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
            'index' => ListConfiguratorSubmissions::route('/'),
            'view' => ViewConfiguratorSubmission::route('/{record}'),
        ];
    }
}
