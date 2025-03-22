<?php

declare(strict_types=1);

namespace Honed\Refine;

class DateFilter extends Filter
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->date();
    }
}
