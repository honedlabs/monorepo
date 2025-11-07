<?php

declare(strict_types=1);

namespace App\Enums;

use Honed\Core\Contracts\HasLabel;

enum Locale: string implements HasLabel
{
    case En = 'en';
    case Es = 'es';

    /**
     * Get the label for the locale.
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::En => 'English',
            self::Es => 'Spanish',
        };
    }
}
