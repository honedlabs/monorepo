<?php

declare(strict_types=1);

namespace Honed\Chart;

class AxisY extends Axis
{
    /**
     * Provide the axis with the default type.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->y();
    }
}
