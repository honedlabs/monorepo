<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Definable
{
    /**
     * Whether the instance has been defined.
     * 
     * @var bool
     */
    protected $defined = false;

    /**
     * Call the definition.
     */
    public function define(): void
    {
        if (! $this->defined) {
            $this->definition();

            $this->defined = true;
        }
    }

    /**
     * Define the instance.
     */
    protected function definition(): static
    {
        return $this;
    }
}
