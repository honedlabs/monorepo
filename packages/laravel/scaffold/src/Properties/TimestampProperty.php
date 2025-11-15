<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

class TimestampProperty extends DateTimeProperty
{
    /**
     * The type of the schema column.
     *
     * @var string
     */
    protected $column = 'timestamp';
}
