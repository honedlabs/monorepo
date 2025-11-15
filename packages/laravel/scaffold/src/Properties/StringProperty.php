<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

use Honed\Scaffold\Contracts\HasLength;
use Honed\Scaffold\Contracts\IsNullable;

class StringProperty extends Property implements HasLength, IsNullable
{
    /**
     * The type of the schema column.
     *
     * @var string
     */
    protected $column = 'string';

    /**
     * The suggested names for the property.
     *
     * @var list<string>
     */
    protected $suggestedNames = [
        'name',
        'title',
        'description',
        'code',
        'image',
        'slug',
        'type',
        'url',
    ];
}
