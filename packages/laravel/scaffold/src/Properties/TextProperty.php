<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

class TextProperty extends Property
{
    /**
     * The type of the schema column.
     * 
     * @var string
     */
    protected $column = 'text';

    /**
     * The suggested names for the property.
     * 
     * @var list<string>
     */
    protected $suggestedNames = [
        'description',
        'content',
        'text',
        'message',
    ];
}