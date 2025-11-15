<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

class DateTimeProperty extends Property
{
    /**
     * The type of the schema column.
     * 
     * @var string
     */
    protected $column = 'dateTime';
}