<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

use function Laravel\Prompts\confirm;

class BooleanProperty extends Property
{
    /**
     * The type of the schema column.
     *
     * @var string
     */
    protected $column = 'boolean';

    /**
     * Prompt the user for the default value of the property.
     */
    public function promptForDefault(): void
    {
        $this->default = confirm(
            label: 'Should the property be defaulted to true?',
            default: false
        );
    }

    /**
     * Cast the given value to the appropriate type.
     *
     * @param  scalar  $value
     * @return bool
     */
    protected function cast(mixed $value): mixed
    {
        return (bool) $value;
    }
}
