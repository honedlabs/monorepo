<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

use Honed\Scaffold\Contracts\IsNullable;

class DateTimeProperty extends Property implements IsNullable
{
    /**
     * The type of the schema column.
     * 
     * @var string
     */
    protected $column = 'dateTime';
}