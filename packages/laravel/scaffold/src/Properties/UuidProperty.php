<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

use Honed\Scaffold\Contracts\HasUniqueness;
use Honed\Scaffold\Contracts\IsNullable;
use Illuminate\Support\Str;

use function Laravel\Prompts\suggest;

class UuidProperty extends Property implements HasUniqueness, IsNullable
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
        'uuid',
        'public_id',
    ];

    /**
     * Prompt the user for the name of the property.
     */
    public function promptForName(): void
    {
        $this->name = Str::snake(suggest(
            label: 'Provide a name for this property',
            options: $this->getSuggestedNames(),
            default: 'uuid'
        ));
    }
}
