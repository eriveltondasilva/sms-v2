<?php

declare(strict_types=1);

namespace App\Enums;

enum Subject: string
{
    case Mathematics = 'Matemática';
    case Portuguese = 'Português';
    case Science = 'Ciências';
    case History = 'História';
    case Geography = 'Geografia';
    case Arts = 'Artes';
    case PhysicalEd = 'Educação Física';
    case English = 'Inglês';
    case Religion = 'Ensino Religioso';
    case Philosophy = 'Filosofia';
    case Sociology = 'Sociologia';

    public function code(): string
    {
        return match ($this) {
            self::Mathematics => 'MAT',
            self::Portuguese  => 'POR',
            self::Science     => 'CIE',
            self::History     => 'HIS',
            self::Geography   => 'GEO',
            self::Arts        => 'ART',
            self::PhysicalEd  => 'EDF',
            self::English     => 'ING',
            self::Religion    => 'ENR',
            self::Philosophy  => 'FIL',
            self::Sociology   => 'SOC',
        };
    }

    public function weekHours(): int
    {
        return match ($this) {
            self::Mathematics, self::Portuguese => 5,
            self::Science, self::History,
            self::Geography, self::English => 3,
            default                        => 2,
        };
    }
}
