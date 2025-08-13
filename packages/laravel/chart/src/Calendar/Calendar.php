<?php

declare(strict_types=1);

namespace Honed\Chart\Calendar;

use Honed\Chart\Calendar\Concerns\HasCellsize;
use Honed\Chart\Calendar\Concerns\HasRange;
use Honed\Chart\Concerns\CanBeSilent;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasItemStyle;
use Honed\Chart\Concerns\HasOrientation;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Chart\Style\Concerns\HasBottom;
use Honed\Chart\Style\Concerns\HasHeight;
use Honed\Chart\Style\Concerns\HasLeft;
use Honed\Chart\Style\Concerns\HasRight;
use Honed\Chart\Style\Concerns\HasTop;
use Honed\Chart\Style\Concerns\HasWidth;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Calendar extends Primitive implements NullsAsUndefined
{
    use CanBeSilent;
    use HasBottom;
    use HasCellsize;
    use HasHeight;
    use HasId;
    use HasItemStyle;
    use HasLeft;
    use HasOrientation;
    use HasRange;
    use HasRight;
    use HasTop;
    use HasWidth;
    use HasZAxis;
    // use HasSplitLine;

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
            'id' => $this->getId(),
            'zLevel' => $this->getZLevel(),
            'z' => $this->getZ(),
            'left' => $this->getLeft(),
            'top' => $this->getTop(),
            'right' => $this->getRight(),
            'bottom' => $this->getBottom(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'range' => $this->getRange(),
            'cellSize' => $this->getCellSize(),
            'orient' => $this->getOrientation(),
            'splitLine' => $this->getSplitLine()?->toArray(),
            'itemStyle' => $this->getItemStyle()?->toArray(),
            // 'dayLabel' => $this->getDayLabel()?->toArray(),
            // 'monthLabel' => $this->getMonthLabel()?->toArray(),
            // 'yearLabel' => $this->getYearLabel()?->toArray(),
            'silent' => $this->isSilent(),
        ];
    }
}
