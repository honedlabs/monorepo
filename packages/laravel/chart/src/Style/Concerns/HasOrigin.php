<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Enums\Origin;

trait HasOrigin
{
    /**
     * The origin position.
     *
     * @var string|int|null
     */
    protected $origin;

    /**
     * Set the origin position.
     *
     * @return $this
     */
    public function origin(string|int|Origin $value): static
    {
        $this->origin = $value instanceof Origin ? $value->value : $value;

        return $this;
    }

    /**
     * Set the origin position to be auto.
     *
     * @return $this
     */
    public function originAuto(): static
    {
        return $this->origin(Origin::Auto);
    }

    /**
     * Set the origin position to be start.
     *
     * @return $this
     */
    public function originStart(): static
    {
        return $this->origin(Origin::Start);
    }

    /**
     * Set the origin position to be end.
     *
     * @return $this
     */
    public function originEnd(): static
    {
        return $this->origin(Origin::End);
    }

    /**
     * Get the origin position.
     */
    public function getOrigin(): string|int|null
    {
        return $this->origin;
    }
}
