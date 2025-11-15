<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\text;

use Honed\Scaffold\Contracts\HasLength;

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
    public function suggest(): void
    {
        $this->promptForName();

        $this->promptForDefault();

        $this->promptForLength();

        $this->promptForUnsigned();

        $this->success();
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
        $integerSize = match ($this->getLength()) {
            'tiny' => 'tinyInteger',
            'small' => 'smallInteger',
            'medium' => 'mediumInteger',
            'integer' => 'integer',
            'big' => 'bigInteger',
            default => 'integer',
        };

        if ($this->isUnsigned()) {
            return 'unsigned'.Str::upper($integerSize);
        }

        return $integerSize;
    }

    /**
     * Prompt the user for the unsigned status of the property.
     */
    protected function promptForUnsigned(): void
    {
        $this->unsigned = confirm('Is this property an unsigned integer?');
    }

    /**
     * Cast the given value to the appropriate type.
     * 
     * @param scalar $value
     * @return int
     */
    protected function cast(mixed $value): mixed
    {
        return (int) $value;
    }
}