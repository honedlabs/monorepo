<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

class Doughnut extends Pie
{
    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->radius(40, 70);
    }
}
