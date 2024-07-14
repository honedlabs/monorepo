<?php

namespace Conquest\Chart\Series\Line;

use Conquest\Chart\Enums\ChartType;
use Conquest\Chart\Series\Concerns\HasStack;
use Conquest\Chart\Series\Concerns\HasStackStrategy;
use Conquest\Chart\Series\Line\Concerns\IsSmooth;
use Conquest\Chart\Series\Series;
use Conquest\Chart\Shared\AreaStyle\Concerns\HasAreaStyle;
use Conquest\Chart\Shared\Emphasis\Concerns\HasEmphasis;

class Line extends Series
{
    use HasAreaStyle;
    use HasEmphasis;
    use HasStack;
    use HasStackStrategy;
    use IsSmooth;

    public function setUp(): void
    {
        $this->setType(ChartType::LINE);
    }

    public function __construct(

    ) {
        parent::__construct();

    }

    public static function make(

    ): static {
        return resolve(static::class, func_get_args());
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            $this->getAreaStyleOptions(),
            $this->isSmoothOption(),
            $this->getStackOption(),
            $this->getStackStrategyOption(),
            $this->getEmphasisOptions(),
        );
    }
}
