<?php

declare(strict_types=1);

namespace Honed\Form\Contracts;

use Honed\Form\Form;

interface Generative
{
    /**
     * Generate a form from the class.
     */
    public static function form(mixed ...$payloads): Form;
}
