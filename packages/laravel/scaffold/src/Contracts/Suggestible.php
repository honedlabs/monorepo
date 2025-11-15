<?php

declare(strict_types=1);

namespace Honed\Scaffold\Contracts;

/**
 * @template T of array-key
 */
interface Suggestible
{
    /**
     * Get the suggestions for the user.
     *
     * @return array<T, string>
     */
    public function suggestions(): array;
}
