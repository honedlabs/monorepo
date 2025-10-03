<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

class DateFormatter extends CarbonFormatter
{
    /**
     * The format to use for formatting dates.
     *
     * @var string
     */
   protected $using = 'Y-m-d';
}