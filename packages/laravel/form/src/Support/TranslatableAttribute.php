<?php

declare(strict_types=1);

namespace Honed\Form\Support;

use Illuminate\Support\Facades\Lang;

/**
 * @extends FunctionalArgument<string>
 */
class TranslatableAttribute extends FunctionalArgument
{
    /**
     * @param  array<string, mixed>  $parameters
     */
    public function __construct(
        public string $key,
        public array $parameters = [],
    ) {}

    /**
     * Get the value.
     */
    public function getValue(): string
    {
        /** @var string */
        return Lang::get($this->key, $this->parameters);
    }
}
