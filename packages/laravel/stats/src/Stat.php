<?php

declare(strict_types=1);

namespace Honed\Stats;

use Honed\Core\Primitive;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasValue;
use Honed\Stats\Concerns\CanGroup;
use Honed\Core\Concerns\CanHaveIcon;
use Illuminate\Database\Eloquent\Model;
use Honed\Core\Concerns\CanHaveAttributes;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Stats\Concerns\CanHaveDescription;

class Stat extends Primitive implements NullsAsUndefined
{
    use CanGroup;
    use CanHaveAttributes;
    use CanHaveDescription;
    use CanHaveIcon;
    use HasLabel;
    use HasName;
    use HasValue;

    /**
     * Create a new stat instance.
     */
    public static function make(string $name, ?string $label = null): static
    {
        return resolve(static::class)
            ->name($name)
            ->label($label ?? static::makeLabel($name));
    }

    /**
     * Get the group of the data.
     */
    public function getGroup(): ?string
    {
        if (is_string($this->group)) {
            return $this->group;
        }

        return null;
    }

    /**
     * Set the value of the stat to be retrieved from a count of a relationship.
     *
     * @param  string|array<string, Closure>|null  $relationship
     * @return $this
     */
    public function count(string|array|null $relationship = null): static
    {
        return $this->newSimpleRelationship($relationship, 'count');
    }

    /**
     * Set the value of the stat to be retrieved from a relationship exists.
     *
     * @param  string|array<string, Closure>|null  $relationship
     * @return $this
     */
    public function exists(string|array|null $relationship = null): static
    {
        return $this->newSimpleRelationship($relationship, 'exists');
    }

    /**
     * Set the value of the stat to be retrieved from an average value of a relationship.
     *
     * @param  string|array<string, Closure>|null  $relationship
     * @return $this
     */
    public function avg(string|array|null $relationship = null, ?string $column = null): static
    {
        return $this->newAggregateRelationship($relationship, $column, 'avg');
    }

    /**
     * Set the value of the stat to be retrieved from an average value of a relationship.
     *
     * @param  string|array<string, Closure>|null  $relationship
     * @return $this
     */
    public function average(string|array|null $relationship = null, ?string $column = null): static
    {
        return $this->avg($relationship, $column);
    }

    /**
     * Set the value of the stat to be retrieved from a sum of a relationship.
     *
     * @param  string|array<string, Closure>|null  $relationship
     * @return $this
     */
    public function sum(string|array|null $relationship = null, ?string $column = null): static
    {
        return $this->newAggregateRelationship($relationship, $column, 'sum');
    }

    /**
     * Set the value of the stat to be retrieved from a maximum value of a relationship.
     *
     * @param  string|array<string, Closure>|null  $relationship
     * @return $this
     */
    public function max(string|array|null $relationship = null, ?string $column = null): static
    {
        return $this->newAggregateRelationship($relationship, $column, 'max');
    }

    /**
     * Set the value of the stat to be retrieved from a minimum value of a relationship.
     *
     * @param  string|array<string, Closure>|null  $relationship
     * @return $this
     */
    public function min(string|array|null $relationship = null, ?string $column = null): static
    {
        return $this->newAggregateRelationship($relationship, $column, 'min');
    }

    /**
     * Get the name of the load method.
     */
    protected function load(string $method): string
    {
        return 'load'.Str::studly($method);
    }

    /**
     * Set the value of the stat to be retrieved from a simple relationship.
     *
     * @param  string|array<string, Closure>|null  $relationship
     * @return $this
     */
    protected function newSimpleRelationship(string|array|null $relationship, string $method): static
    {
        return $this->value(match (true) {
            (bool) $relationship => fn (Model $record) => $record->{$this->load($method)}($relationship),
            default => fn (Model $record) => $record->{$this->load($method)}(
                Str::beforeLast($this->getName(), '_'.$method),
            ),
        });
    }

    /**
     * Set the value of the stat to be retrieved from an aggregate relationship.
     *
     * @param  string|array<string, Closure>|null  $relationship
     * @return $this
     */
    protected function newAggregateRelationship(string|array|null $relationship, ?string $column, string $method): static
    {
        if ($relationship && ! $column) {
            throw new InvalidArgumentException(
                'A column must be specified when an aggregate relationship is used.'
            );
        }

        return $this->value(match (true) {
            (bool) $relationship => fn (Model $record) => $record->{$this->load($method)}($relationship, $column),
            default => fn (Model $record) => $record->{$this->load($method)}(
                Str::beforeLast($this->getName(), '_'.$method),
                Str::afterLast($this->getName(), $method.'_'),
            ),
        });
    }

    /**
     * Define the stat.
     *
     * @return $this
     */
    protected function definition(): static
    {
        return $this;
    }

    /**
     * Get the representation of the stat.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'icon' => $this->getIcon(),
            'description' => $this->getDescription(),
            'attributes' => $this->getAttributes(),
        ];
    }
}
