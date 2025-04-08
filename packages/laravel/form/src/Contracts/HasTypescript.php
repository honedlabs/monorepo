<?php

declare(strict_types=1);

namespace Honed\Form\Contracts;

/**
 * @phpstan-require-extends \Illuminate\Validation\Rule
 */
interface HasTypescript
{
    /**
     * Get the type to be used in the typescript definition.
     * 
     * @return string|array<string,mixed>
     */
    public function typescriptType();
}