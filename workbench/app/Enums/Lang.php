<?php

enum Lang: string
{
    case ENGLISH = 'en';
    case FRENCH = 'fr';
    case SPANISH = 'es';
    case GERMAN = 'de';
    case ITALIAN = 'it';

    public function label(): string
    {
        return match ($this) {
            self::ENGLISH => 'English',
            self::FRENCH => 'Français',
            self::SPANISH => 'Español',
            self::GERMAN => 'Deutsch',
            self::ITALIAN => 'Italiano',
        };
    }
}