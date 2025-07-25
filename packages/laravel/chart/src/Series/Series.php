<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Enums\ChartType;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Series extends Primitive implements NullsAsUndefined
{
    /**
     * The type of the series.
     * 
     * @var \Honed\Chart\Enums\ChartType
     */
    protected $type;

    /**
     * Set the type of the series.
     * 
     * @param \Honed\Chart\Enums\ChartType|string $type
     * @return $this
     * 
     * @throws \ValueError if the type is not a valid chart type
     */
    public function type(ChartType|string $type): static
    {
        if (! $type instanceof ChartType) {
            $type = ChartType::from($type);
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Get the type of the series.
     * 
     * @return \Honed\Chart\Enums\ChartType|string
     */
    public function getType(): ChartType
    {
        return $this->type;
    }

    /**
     * Get the representation of the series.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}