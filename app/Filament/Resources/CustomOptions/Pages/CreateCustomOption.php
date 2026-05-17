<?php

namespace App\Filament\Resources\CustomOptions\Pages;

use App\Filament\Resources\CustomOptions\CustomOptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomOption extends CreateRecord
{
    protected static string $resource = CustomOptionResource::class;
}
