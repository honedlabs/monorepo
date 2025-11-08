<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Delegate;
use Honed\Form\Form;
use Honed\Form\Generators\DataGenerator;

/**
 * @phpstan-require-extends \Spatie\LaravelData\Data|\Illuminate\Http\Request
 */
trait GeneratesForm
{
    /**
     * Generate a form from the class.
     */
    public static function form(mixed ...$payloads): Form
    {
        return Delegate::to(static::class)->generate(...$payloads);
    }
}
