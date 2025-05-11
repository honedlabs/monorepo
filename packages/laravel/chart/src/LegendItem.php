<?php

declare(strict_types=1);

namespace Honed\Chart;

use JsonSerializable;
use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Concerns\FiltersUndefined;
use Honed\Chart\Concerns\HasShape;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements \Illuminate\Contracts\Support\Arrayable<string, mixed>
 */
class LegendItem implements Arrayable, JsonSerializable
{
    use FiltersUndefined;
    use HasColor;
    use HasShape;

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->filterUndefined([
            // 'name' => $this->label,
            ...$this->colorToArray(),
            'shape',
            'inactive',
            'hidden',
            'pointer'
        ]);
    }
}
