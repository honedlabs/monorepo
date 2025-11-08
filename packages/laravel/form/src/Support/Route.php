<?php

declare(strict_types=1);

namespace Honed\Form\Support;

use Illuminate\Support\Facades\URL as UrlGenerator;

/**
 * @extends FunctionalArgument<string>
 */
final class Url extends FunctionalArgument
{
    public function __construct(
        public readonly string $name,
        public readonly mixed $parameters = [],
    ) {}

    /**
     * Get the value of the translation.
     */
    public function getValue(): string
    {
        return UrlGenerator::route($this->name, $this->parameters);
    }
}
