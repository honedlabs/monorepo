<?php

namespace Conquest\Chart\Series\Line;

use Conquest\Chart\Enums\ChartType;
use Conquest\Chart\Series\Series;

class Line extends Series
{
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