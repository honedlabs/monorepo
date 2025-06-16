<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Closure;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasType;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;
use Illuminate\Database\Eloquent\Model;

abstract class BaseEntry extends Primitive implements NullsAsUndefined
{
    use Allowable;
    use Concerns\CanBeBadge;
    use Concerns\HasPlaceholder;
    use Concerns\HasState;
    use HasLabel;
    use HasType;

    public const NUMERIC = 'numeric';

    public const TEXT = 'text';

    public const TIME = 'time';

    /**
     * Format the value of the entry.
     */
    abstract public function format(mixed $value): mixed;

    /**
     * Create a new list entry.
     *
     * @param  string|Closure  $state
     * @return static
     */
    public static function make(string|Closure|null $state = null, ?string $label = null): static
    {
        return resolve(static::class)
            ->state($state)
            ->label($label ?? is_string($state) ? static::makeLabel($state) : null);
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($named = [], $typed = [])
    {
        $state = $this->getState();

        $placehold = false;

        if (is_null($state)) {
            $state = $this->getPlaceholder();
            $placehold = ! is_null($state);
        }

        return [
            'type' => $this->getType(),
            'label' => $this->getLabel(),
            'state' => $state,
            'placehold' => $placehold ?: null,
            'badge' => $this->isBadge(),
            'variant' => $this->getVariant(),
        ];
    }

    /**
     * Provide a selection of default dependencies for evaluation by name.
     *
     * @param  string  $parameterName
     * @return array<int, mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
    {
        return match ($parameterName) {
            'record', 'row' => [$this->getRecord()],
            'state' => [$this->getState()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * Provide a selection of default dependencies for evaluation by type.
     *
     * @param  class-string  $parameterType
     * @return array<mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
    {
        $record = $this->getRecord();

        if (! $record instanceof Model) {
            return parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType);
        }

        return match ($parameterType) {
            Model::class, $record::class => [$record],
            default => parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
        };
    }
}
