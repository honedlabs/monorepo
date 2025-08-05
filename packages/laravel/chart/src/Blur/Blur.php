<?php

declare(strict_types=1);

namespace Honed\Chart\Blur;

use Honed\Chart\Concerns\HasItemStyle;
use Honed\Chart\Concerns\HasLabel;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Blur extends Primitive implements NullsAsUndefined
{
    use HasItemStyle;
    use HasLabel;


    /**
     * Create a new blur instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the representation of the blur.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'itemStyle' => $this->getItemStyle()?->toArray(),
            'label' => $this->getLabel()?->toArray(),
            'labelLine' => $this->getLabelLine()?->toArray(),
        ];
    }
}