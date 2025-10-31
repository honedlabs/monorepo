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
     *
     * @return $this
     */
    protected function definition(): static
    {
        return $this;
    }
}
