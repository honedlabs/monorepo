<?php

namespace Conquest\Chart\Series\Line;

use Conquest\Chart\Enums\ChartType;
use Conquest\Chart\Series\Series;
use Conquest\Chart\Shared\AreaStyle\Concerns\HasAreaStyle;

class Line extends Series
{
    use HasAreaStyle;
    
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
    
}