<?php

declare(strict_types=1);

namespace Honed\Form\Support;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL as UrlGenerator;
use Spatie\LaravelData\Support\Validation\References\FieldReference;

/**
 * @template T
 */
abstract class FunctionalArgument
{
    /**
     * Get the value.
     * 
     * @return T
     */
    abstract public function getValue();
}