<?php

namespace App\Filament\Pages;

use App\Settings\TopbarSettings;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Cache;

class ManageTopbar extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings = TopbarSettings::class;

    protected static ?string $navigationLabel = 'Setări Topbar';

    protected static ?string $title = 'Setări Topbar';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('phone_number')
                    ->label('Număr de telefon')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->required()
            ]);
    }

    protected function afterSave(): void
    {
        Cache::forget('topbar_settings_v1');
    }
}
