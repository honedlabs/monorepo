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
     *
     * @return $this
     *
     * @internal
     */
    public function define(): static
    {
        if (! $this->defined) {
            $this->definition();

            $this->defined = true;
        }

        return $this;
    }

    /**
     * Define the instance.
     */
    protected function definition(): static
    {
        return $this;
    }
}
