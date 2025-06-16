<?php

declare(strict_types=1);

namespace Honed\List\Entries;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Primitive;
use Illuminate\Database\Eloquent\Model;

abstract class BaseEntry extends Primitive
{
    use Allowable;
    use HasType;
    use HasLabel;
    use HasValue;
    use Concerns\HasPlaceholder;

    /**
     * The state of the entry to use.
     * 
     * @var string|\Closure
     */
    protected string|\Closure $state;

    /**
     * Set the state of the entry to use.
     * 
     * @param  string|\Closure  $state
     * @return $this
     */
    public function state(string|\Closure $state): static
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Create a new list entry.
     * 
     * @param  string  $label
     * @param  string|\Closure  $value
     * @return \Honed\List\Entry
     */
    public static function make(?string $label = null, mixed $value = null): static
    {
        return resolve(static::class)
            ->label($label)
            ->value($value);
    }

    /**
     * Format the value of the entry.
     * 
     * @param  mixed  $value
     * @return mixed
     */
    abstract public function format(mixed $value): mixed;

    /**
     * Create the entry for the resource.
     * 
     * @param  array<string, mixed>|\Illuminate\Database\Eloquent\Model  $resource
     * @return array<string, mixed>
     */
    public function build(array|Model $resource): array
    {
        $this->stateful($resource);

        return [
            'type' => $this->getType(),
            'label' => $this->getLabel(),
            'value' => $this->getValue(),
            'none' => $this->isDefaulted(),
        ];
    }

    /**
     * Get the instance as an array.
     * 
     * @return array<string, mixed>
     */
    public function toArray($named = [], $typed = [])
    {
        return [
            'type' => $this->getType(),
            'label' => $this->getLabel(),
            'value' => $this->getValue(),
            'none' => $this->isDefaulted(),
        ];
    }

    protected function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
    {
        return match ($parameterName) {
            // 'record', 'row' => [$this->getRecord()],
            // 'state' => [$this->getState()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * @return array<mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
    {
        // $record = $this->getRecord();

        // if (! $record) {
        //     return parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType);
        // }

        return match ($parameterType) {
            // Model::class, $record::class => [$record],
            default => parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
        };
    }

}