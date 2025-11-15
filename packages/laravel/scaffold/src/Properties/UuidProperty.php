<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

use Honed\Scaffold\Contracts\HasUniqueness;

class UuidProperty extends Property implements HasUniqueness
{
    /**
     * The type of the schema column.
     * 
     * @var string
     */
    protected $column = 'uuid';

    /**
     * The suggested names for the property.
     * 
     * @var list<string>
     */
    protected $suggestedNames = [
        'uuid'
    ];
}