<?php

declare(strict_types=1);

namespace Honed\Form\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Form\Form
 */
class Form extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Form\Form::class;
    }
}