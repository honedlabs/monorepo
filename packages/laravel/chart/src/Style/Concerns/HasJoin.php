<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Enums\Join;

trait HasJoin
{
    /**
     * How the end points of the line are drawn.
     *
     * @var string|null
     */
    protected $join;

    /**
     * The miter limit.
     *
     * @var int|null
     */
    protected $miterLimit;

    /**
     * Set the join of the line.
     *
     * @return $this
     */
    public function join(string|Join $value): static
    {
        $this->join = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the join of the line to be butt.
     *
     * @return $this
     */
    public function bevel(): static
    {
        return $this->join(Join::Bevel);
    }

    /**
     * Set the join of the line to be miter.
     *
     * @param  int|null  $value  The miter limit ratio
     * @return $this
     */
    public function miter(?int $value = null): static
    {
        return $this->join(Join::Miter)->miterLimit($value);
    }

    /**
     * Get the join of the line.
     */
    public function getJoin(): ?string
    {
        return $this->join;
    }

    /**
     * Set the miter limit.
     *
     * @return $this
     */
    public function miterLimit(?int $value): static
    {
        $this->miterLimit = $value;

        return $this;
    }

    /**
     * Get the miter limit.
     */
    public function getMiterLimit(): ?int
    {
        return $this->miterLimit;
    }
}
