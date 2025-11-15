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

    /**
     * The suggested names for the property.
     *
     * @var list<string>
     */
    protected $suggestedNames = [
        'disabled_at',
        'enabled_at',
        'verified_at',
        'expired_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
