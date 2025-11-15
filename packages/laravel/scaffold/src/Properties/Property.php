<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

use Honed\Scaffold\Contracts\HasLength;
use Honed\Scaffold\Contracts\HasUniqueness;
use Honed\Scaffold\Contracts\IsNullable;
use Honed\Scaffold\Contracts\Property as PropertyContract;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

abstract class Property implements PropertyContract
{
    /**
     * The name of the property.
     *
     * @var string
     */
    protected $name;

    /**
     * The type of the schema column.
     *
     * @var string
     */
    protected $column;

    /**
     * Whether the property is nullable.
     *
     * @var bool
     */
    protected $nullable = false;

    /**
     * The default value of the property.
     *
     * @var scalar|null
     */
    protected $default;

    /**
     * The length of the property.
     *
     * @var int
     */
    protected $length;

    /**
     * Whether the property is unique.
     *
     * @var bool
     */
    protected $unique = false;

    /**
     * The suggested names for the property.
     *
     * @var list<string>
     */
    protected $suggestedNames = [];

    /**
     * Create a new property instance.
     */
    public static function make(): static
    {
        return app(static::class);
    }

    /**
     * Prompt the user for input.
     */
    public function prompt(): void
    {
        $this->promptForName();

        $this->promptForNullable();

        $this->promptForDefault();

        $this->promptForLength();

        $this->promptForUniqueness();
    }

    /**
     * Get the blueprint for the property, without the trailing semicolon.
     */
    public function getBlueprint(): Stringable
    {
        return (new Stringable('$table->'))
            ->append($this->getBlueprintColumn(), '(\'', $this->name)
            ->when(
                $this instanceof HasLength && $this->hasLength(),
                fn (Stringable $string) => $string
                    ->append(', ', $this->getLength(), ')'),
                fn (Stringable $string) => $string
                    ->append(')'),
            )
            ->when(
                $this->isNullable(),
                fn (Stringable $string) => $string
                    ->append('->nullable()'),
            )
            ->when(
                $this->hasDefault(),
                fn (Stringable $string) => $string
                    ->append('->default(', $this->default, ')'),
            )
            ->when(
                $this->isUnique(),
                fn (Stringable $string) => $string
                    ->append('->unique()'),
            );
    }

    /**
     * Get the name of the property.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the column type of the property.
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * Get the column type of the property for the blueprint.
     */
    public function getBlueprintColumn(): string
    {
        return $this->getColumn();
    }

    /**
     * Determine whether the property is nullable.
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * Determine whether the property has a default value.
     */
    public function hasDefault(): bool
    {
        return isset($this->default);
    }

    /**
     * Get the length of the property.
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * Determine whether the property has a length.
     */
    public function hasLength(): bool
    {
        return isset($this->length);
    }

    /**
     * Determine whether the property is unique.
     */
    public function isUnique(): bool
    {
        return $this->unique;
    }

    /**
     * Prompt the user for the name of the property.
     */
    public function promptForName(): void
    {
        $this->name = Str::snake(suggest(
            label: 'Provide a name for this property',
            options: $this->getSuggestedNames(),
        ));
    }

    /**
     * Prompt the user for whether the property is nullable.
     */
    public function promptForNullable(): void
    {
        if ($this instanceof IsNullable) {
            $this->nullable = confirm(
                label: 'Is this property nullable?'
            );
        }
    }

    /**
     * Prompt the user for the default value of the property.
     */
    public function promptForDefault(): void
    {
        if (! $this->isNullable() && $this->confirms('default value')) {
            $this->default = $this->cast(text(
                label: 'Provide a default value for this property'
            ));
        }
    }

    /**
     * Prompt the user for the length of the property.
     */
    public function promptForLength(): void
    {
        if ($this instanceof HasLength && $this->confirms('length')) {
            $this->length = $this->cast(suggest(
                label: 'Provide a length for this property',
                options: [
                    '63',
                    '127',
                    '255',
                    '511',
                    '1023',
                    '2047',
                    '4095',
                    '65535',
                ]
            ));
        }
    }

    /**
     * Prompt the user for whether the property is unique.
     */
    public function promptForUniqueness(): void
    {
        if ($this instanceof HasUniqueness) {
            $this->unique = confirm(
                label: 'Is this property unique?'
            );
        }
    }

    /**
     * Prompt the user for whether they want a default value for the property.
     */
    protected function confirms(string $question): bool
    {
        return confirm(
            label: "Does this property have a {$question}?",
        );
    }

    /**
     * Cast the given value to the appropriate type.
     *
     * @param  scalar  $value
     * @return scalar
     */
    protected function cast(mixed $value): mixed
    {
        return $value;
    }

    /**
     * Get the suggested names for the property.
     *
     * @return list<string>
     */
    protected function getSuggestedNames(): array
    {
        return $this->suggestedNames;
    }
}
