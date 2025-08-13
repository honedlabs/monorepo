<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

use Honed\Chart\Enums\Position;

trait HasPosition
{
    /**
     * The position.
     *
     * @var string|null
     */
    protected $position;

    /**
     * Set the position.
     *
     * @return $this
     */
    public function position(string|Position $value): static
    {
        $this->position = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the position to be top.
     *
     * @return $this
     */
    public function positionTop(): static
    {
        return $this->position(Position::Top);
    }

    /**
     * Set the position to be left.
     *
     * @return $this
     */
    public function positionLeft(): static
    {
        return $this->position(Position::Left);
    }

    /**
     * Set the position to be bottom..
     *
     * @return $this
     */
    public function positionBottom(): static
    {
        return $this->position(Position::Bottom);
    }

    /**
     * Set the position to be right.
     *
     * @return $this
     */
    public function positionRight(): static
    {
        return $this->position(Position::Right);
    }

    /**
     * Get the position.
     */
    public function getPosition(): ?string
    {
        return $this->position;
    }
}
