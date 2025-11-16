<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

use Honed\Scaffold\Contracts\HasLength;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;

class NumberProperty extends Property implements HasLength
{
    /**
     * Whether the property is unsigned.
     *
     * @var bool
     */
    protected $unsigned = false;

    /**
     * The type of the schema column.
     *
     * @var string
     */
    protected $column = 'integer';

    /**
     * The size of the integer.
     *
     * @var string
     */
    protected $size = 'integer';

    /**
     * The suggested names for the property.
     *
     * @var list<string>
     */
    protected $suggestedNames = [
        'price',
        'amount',
        'quantity',
        'type',
        'status',
    ];

    /**
     * Prompt the user for input.
     */
    public function prompt(): void
    {
        parent::prompt();

        $this->promptForUnsigned();

        $this->promptForSize();
    }

    /**
     * Prompt the user for the unsigned status of the property.
     */
    public function promptForUnsigned(): void
    {
        $this->unsigned = confirm(
            label: 'Is this property an unsigned integer?',
            default: true
        );
    }

    /**
     * Prompt the user for the length of the property.
     */
    public function promptForSize(): void
    {
        $this->size = select(
            label: 'Provide a size for this integer',
            options: [
                'tiny' => 'Tiny integer',
                'small' => 'Small integer',
                'medium' => 'Medium integer',
                'integer' => 'Integer',
                'big' => 'Big integer',
            ],
            default: 'integer'
        );
    }

    /**
     * Determine whether the property is unsigned.
     */
    public function isUnsigned(): bool
    {
        return $this->unsigned;
    }

    /**
     * Get the column type of the property for the blueprint.
     */
    public function getBlueprintColumn(): string
    {
        $integerSize = match ($this->getSize()) {
            'tiny' => 'tinyInteger',
            'small' => 'smallInteger',
            'medium' => 'mediumInteger',
            'big' => 'bigInteger',
            default => 'integer',
        };

        if ($this->isUnsigned()) {
            return 'unsigned'.Str::upper($integerSize);
        }

        return $integerSize;
    }

    /**
     * Get the integer size.
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * Cast the given value to the appropriate type.
     *
     * @param  scalar  $value
     * @return int
     */
    protected function cast(mixed $value): mixed
    {
        return (int) $value;
    }
}
