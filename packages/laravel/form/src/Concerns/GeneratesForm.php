<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Form;
use Honed\Form\Generators\DataGenerator;

/**
 * @phpstan-require-extends \Spatie\LaravelData\Data
 */
trait GeneratesForm
{
    public static function form(mixed ...$payloads): Form
    {
        return DataGenerator::make(static::class)
            ->generate(...$payloads);
    }
}
