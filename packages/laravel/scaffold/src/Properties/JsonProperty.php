<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

class JsonProperty extends Property
{
    /**
     * The type of the schema column.
     * 
     * @var string
     */
    protected $column = 'json';

    /**
     * The suggested names for the property.
     * 
     * @var list<string>
     */
    protected $suggestedNames = [
        'data',
        'settings',
        'json',
        'config',
        'meta',
    ];
}