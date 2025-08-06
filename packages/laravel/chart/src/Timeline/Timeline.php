<?php

declare(strict_types=1);

namespace Honed\Chart\Timeline;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasOrientation;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Chart\Style\Concerns\HasLeft;
use Honed\Chart\Style\Concerns\HasTop;
use Honed\Chart\Style\Concerns\HasRight;
use Honed\Chart\Style\Concerns\HasBottom;
use Honed\Chart\Style\Concerns\HasWidth;
use Honed\Chart\Style\Concerns\HasHeight;
use Honed\Chart\Support\Concerns\CanKeepAspect;
use Honed\Chart\Support\Concerns\HasSymbol;
use Honed\Chart\Support\Concerns\HasSymbolOffset;
use Honed\Chart\Support\Concerns\HasSymbolSize;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Timeline extends Primitive implements NullsAsUndefined
{
    use CanBeShown;
    // use HasAxisType;
    use HasSymbol;
    use HasSymbolSize;
    use HasSymbolOffset;
    // use HasSymbolPosition;
    // use HasSymbolRotate;
    use CanKeepAspect;

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