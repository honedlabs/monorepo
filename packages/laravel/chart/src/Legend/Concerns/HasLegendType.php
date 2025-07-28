<?php

declare(strict_types=1);

namespace Honed\Chart\Legend\Concerns;

use Honed\Chart\Enums\LegendType;

trait HasLegendType
{
    /**
     * The type of legend.
     * 
     * @var \Honed\Chart\Enums\LegendType|null
     */
    protected $type;

    /**
     * Set the type of legend.
     * 
     * @return $this
     * 
     * @throws \ValueError if the legend type is not a valid legend type
     */
    public function type(LegendType|string $value): static
    {
        if (! $value instanceof LegendType) {
            $value = LegendType::from($value);
        }

        $this->type = $value;

        return $this;
    }

    /**
     * Get the type of legend.
     */
    public function getType(): ?string
    {
        return $this->type?->value;
    }
}