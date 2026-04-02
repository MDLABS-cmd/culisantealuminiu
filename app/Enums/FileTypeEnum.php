<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FileTypeEnum: string implements HasLabel
{
    case CSV = 'csv';
    case XLSX = 'xlsx';
    case JSON = 'json';
    case XML = 'xml';
    case IMAGE = 'image';
    case PDF = 'pdf';
    case UNKNOWN = 'unknown';

    public function getLabel(): string
    {
        return match ($this) {
            self::CSV => 'CSV',
            self::XLSX => 'XLSX',
            self::JSON => 'JSON',
            self::XML => 'XML',
            self::IMAGE => 'Image',
            self::PDF => 'PDF',
            self::UNKNOWN => 'Unknown',
        };
    }

    public static function fromMimeType(string $mime): self
    {
        return match (true) {
            str_contains($mime, 'json') => self::JSON,
            str_contains($mime, 'xml') => self::XML,
            str_contains($mime, 'spreadsheetml') || str_contains($mime, 'excel') => self::XLSX,
            str_contains($mime, 'image') => self::IMAGE,
            str_contains($mime, 'pdf') => self::PDF,
            default => self::UNKNOWN,
        };
    }
}
