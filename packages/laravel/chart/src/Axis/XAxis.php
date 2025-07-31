<?php

declare(strict_types=1);

namespace Honed\Chart\Axis;

class XAxis extends Axis
{
    /**
     * Provide the axis with the default type.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->x();
    }
}