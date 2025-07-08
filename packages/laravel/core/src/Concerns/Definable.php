<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Definable
{
    /**
     * Call the definition.
     */
    public function define(): void
    {
        $this->definition();
    }

    /**
     * Define the instance.
     */
    protected function definition(): static
    {
        return $this;
    }
}
