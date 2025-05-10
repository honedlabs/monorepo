<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

use Honed\Chart\Series;
use Honed\Chart\Support\Constants;

class Pie extends Series
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return Constants::PIE_CHART;
    }
}