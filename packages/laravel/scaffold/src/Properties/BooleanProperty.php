<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

use function Laravel\Prompts\select;

class BooleanProperty extends Property
{
    /**
     * The type of the schema column.
     *
     * @var string
     */
    protected $column = 'boolean';

    /**
     * The suggested names for the property.
     *
     * @var list<string>
     */
    protected $suggestedNames = [
        'is_active',
        'is_enabled',
        'is_visible',
        'is_approved',
        'is_verified',
    ];

    /**
     * Prompt the user for the default value of the property.
     */
    public function promptForDefault(): void
    {
        /** @var 'true' | 'false' */
        $default = select(
            label: 'What should the property be defaulted to?',
            options: [
                'true' => 'True',
                'false' => 'False',
            ],
            default: 'false',
        );

        $this->default = $default === 'true';

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
