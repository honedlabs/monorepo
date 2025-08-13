<?php

declare(strict_types=1);

namespace Honed\Chart\Timeline;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Support\Concerns\CanKeepAspect;
use Honed\Chart\Support\Concerns\HasSymbol;
use Honed\Chart\Support\Concerns\HasSymbolOffset;
use Honed\Chart\Support\Concerns\HasSymbolSize;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Timeline extends Primitive implements NullsAsUndefined
{
    use CanBeShown;

    // use HasSymbolPosition;
    // use HasSymbolRotate;
    use CanKeepAspect;
    // use HasAxisType;
    use HasSymbol;
    use HasSymbolOffset;

    use HasSymbolSize;

    /**
     * Create a new calendar instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the representation of the calendar.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'type' => 'slider',
            // 'axisType' => $this->getAxisType(),
            // 'currentIndex' => $this->getCurrentIndex(),
            // 'autoPlay' => $this->isAutoplayable(),
            // 'rewind' => $this->isRewindable(),
            // 'loop' => $this->shouldLoop(),
            // 'playInterval' => $this->getPlayInterval(),
            'symbol' => $this->getSymbol(),
            'symbolSize' => $this->getSymbolSize(),
            'symbolOffset' => $this->getSymbolOffset(),
            // 'symbolPosition' => $this->getSymbolPosition(),
            // 'symbolRotate' => $this->getSymbolRotate(),
        ];
    }
}
