<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use Honed\Infolist\Formatters\Support\CarbonFormatter;

class DateFormatter extends CarbonFormatter
{
    /**
     * The format to use for formatting dates.
     *
     * @var string
     */
    protected $using = 'Y-m-d';
}
