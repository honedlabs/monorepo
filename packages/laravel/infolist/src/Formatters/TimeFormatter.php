<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use Honed\Infolist\Contracts\Formatter;

/**
 * @implements Formatter<mixed, mixed>
 */
class TimeFormatter extends CarbonFormatter
{
    /**
     * The format to use for formatting times.
     *
     * @var string
     */
    protected $using = 'H:i:s';
}