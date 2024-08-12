<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BrandEngine: string implements HasLabel
{
    case Cummins = 'cummins';
    case Deutz = 'deutz';
    case Fawde = 'fawde';
    case MWM = 'mwm';
    case MAN = 'man';
    case Isuzu = 'isuzu';
    case Perkins = 'perkins';
    case Primero = 'primero';
    case Powerol = 'powerol';
    case Yanmar = 'yanmar';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Cummins => 'Cummins',
            self::Deutz => 'Deutz',
            self::Fawde => 'Fawde',
            self::MWM => 'MWM',
            self::MAN => 'MAN',
            self::Isuzu => 'Isuzu',
            self::Perkins => 'Perkins',
            self::Primero => 'Primero',
            self::Powerol => 'Powerol Mahindra',
            self::Yanmar => 'Yanmar',
        };
    }
}
