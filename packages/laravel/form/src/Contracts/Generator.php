<?php

declare(strict_types=1);

namespace Honed\Form\Contracts;

use Honed\Form\Form;

/**
 * @template T of \Spatie\LaravelData\Data|\Illuminate\Http\Request
 */
interface Generator
{
    /**
     * Create a new generator instance.
     *
     * @param  class-string<T>  $className
     */
    public static function make(string $className): static;

    /**
     * Generate a form.
     *
     * @throws \Honed\Form\Exceptions\CannotResolveComponent
     */
    public function generate(mixed ...$payloads): Form;
}
