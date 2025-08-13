<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Enums\Cap;

trait HasCap
{
    /**
     * How the end points of the line are drawn.
     *
     * @var string|null
     */
    protected $cap;

    /**
     * Set the cap of the line.
     *
     * @return $this
     */
    public function cap(string|Cap $value): static
    {
        $this->cap = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the cap of the line to be butt.
     *
     * @return $this
     */
    public function butt(): static
    {
        return $this->cap(Cap::Butt);
    }

    /**
     * Set the cap of the line to be square.
     *
     * @return $this
     */
    public function square(): static
    {
        return $this->cap(Cap::Square);
    }

    /**
     * Get the cap of the line.
     */
    public function getCap(): ?string
    {
        return $this->cap;
    }
}
