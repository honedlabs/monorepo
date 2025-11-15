<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

class DateProperty extends DateTimeProperty
{
    /**
     * The type of the schema column.
     *
     * @var string
     */
    protected $column = 'date';
}
