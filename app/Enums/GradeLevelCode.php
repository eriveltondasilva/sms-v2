<?php

declare(strict_types=1);

namespace App\Enums;

enum GradeLevelCode: string
{
    // # Elementary School (Ensino Fundamental I)
    case EF_1A = 'EF-1A';
    case EF_2A = 'EF-2A';
    case EF_3A = 'EF-3A';
    case EF_4A = 'EF-4A';
    case EF_5A = 'EF-5A';

    // # Middle School (Ensino Fundamental II)
    case EF_6A = 'EF-6A';
    case EF_7A = 'EF-7A';
    case EF_8A = 'EF-8A';
    case EF_9A = 'EF-9A';

    // TODO: implementar
    // # High School (Ensino Médio)
    // case EM_1S = 'EM-1S';
    // case EM_2S = 'EM-2S';
    // case EM_3S = 'EM-3S';

    public function label(): string
    {
        return match ($this) {
            // # Elementary School
            self::EF_1A => '1º Ano',
            self::EF_2A => '2º Ano',
            self::EF_3A => '3º Ano',
            self::EF_4A => '4º Ano',
            self::EF_5A => '5º Ano',
            // # Middle School
            self::EF_6A => '6º Ano',
            self::EF_7A => '7º Ano',
            self::EF_8A => '8º Ano',
            self::EF_9A => '9º Ano',
            // TODO: implementar
            // # High School
            // self::EM_1S => '1ª Série',
            // self::EM_2S => '2ª Série',
            // self::EM_3S => '3ª Série',
        };
    }

    public function isElementarySchool(): bool
    {
        return match ($this) {
            self::EF_1A, self::EF_2A, self::EF_3A, self::EF_4A, self::EF_5A => true,
            default                                                         => false,
        };
    }

    public function isMiddleSchool(): bool
    {
        return match ($this) {
            self::EF_6A, self::EF_7A, self::EF_8A, self::EF_9A => true,
            default                                            => false,
        };
    }

    // TODO: implementar
    // public function isHighSchool(): bool { ... }

    public function stage(): string
    {
        return match (true) {
            $this->isElementarySchool() => 'Ensino Fundamental I',
            $this->isMiddleSchool()     => 'Ensino Fundamental II',
            default                     => 'Etapa não definida',
            // TODO: implementar
            // $this->isHighSchool() => 'Ensino Médio',
        };
    }
}
