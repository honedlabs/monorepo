<?php

declare(strict_types=1);

namespace Honed\Chart\Legend\Concerns;

use Honed\Chart\Enums\LegendType;

trait HasLegendType
{
    /**
     * The type of legend.
     *
     * @var string|null
     */
    protected $type;

    /**
     * Set the type of legend.
     *
     * @return $this
     */
    public function type(string|LegendType $value): static
    {
        $this->type = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the type of legend to be simple.
     *
     * @return $this
     */
    public function plain(): static
    {
        return $this->type(LegendType::Plain);
    }

    /**
     * Set the type of legend to be scroll.
     *
     * @return $this
     */
    public function scroll(): static
    {
        return $this->type(LegendType::Scroll);
    }

    /**
     * Get the type of legend.
     */
    public function getType(): ?string
    {
        return $this->type;
    }
}
