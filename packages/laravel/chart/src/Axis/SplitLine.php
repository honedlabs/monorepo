<?php

declare(strict_types=1);

namespace Honed\Chart\Axis;

use Honed\Chart\Axis\Concerns\HasInterval;

class SplitLine extends MinorSplitLine
{
    use HasInterval;

    /**
     * Get the array representation of the split line.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            // 'showMinLine' => $this->isShowingMinLine(),
            // 'showMaxLine' => $this->isShowingMaxLine(),
            'interval' => $this->getInterval(),
        ];
    }
}