<?php

declare(strict_types=1);

namespace Honed\Form\Support;

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
