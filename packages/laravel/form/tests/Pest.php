<?php

declare(strict_types=1);

use Honed\Form\Tests\TestCase;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\DataConfig;
use Spatie\LaravelData\Support\DataProperty;

uses(TestCase::class)->in(__DIR__);

/**
 * Get the first property of a data class.
 *
 * @param  class-string<Data>|Data  $class
 */
function property(string|Data $class): DataProperty
{
    return app(DataConfig::class)
        ->getDataClass(is_string($class) ? $class : get_class($class))
        ->properties
        ->first();
}
