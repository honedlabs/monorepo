<?php

declare(strict_types=1);

namespace Honed\Form\Support;

use Illuminate\Support\Facades\Lang;

/**
 * @extends FunctionalArgument<string>
 */
final class Trans extends FunctionalArgument
{
    public function __construct(
        public readonly string $key,
    ) { }

    /**
     * Get the value of the translation.
     */
    public function getValue(): string
    {
        /** @var string */
        return Lang::get($this->key);
    }
}