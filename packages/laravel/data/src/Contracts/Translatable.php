<?php

declare(strict_types=1);

namespace Honed\Data\Contracts;

interface Translatable
{
    /**
     * Translate the fields of the data.
     *
     * @param  mixed  ...$payloads
     */
    public static function translate(...$payloads): void;
}
