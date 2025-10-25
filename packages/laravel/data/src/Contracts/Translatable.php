<?php

declare(strict_types=1);

namespace Honed\Data\Contracts;

interface Translatable
{
    /**
     * Translate the fields of the data.
     */
    public static function translate(mixed ...$payloads): void;
}
