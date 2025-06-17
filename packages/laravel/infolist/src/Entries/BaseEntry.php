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

/**
 * @extends \Honed\Core\Primitive<string, mixed>
 */
abstract class BaseEntry extends Primitive implements NullsAsUndefined
{
    use Allowable;
    use Concerns\CanBeBadge;
    use Concerns\HasClasses;
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
     */
    public static function make(string|Closure|null $state = null, ?string $label = null): static
    {
        $label ??= is_string($state) ? static::makeLabel($state) : null;

        return resolve(static::class)
            ->state($state)
            ->label($label);
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray()
    {
        $state = $this->getState();

        [$state, $placehold] = match (true) {
            is_null($state) => [$this->getPlaceholder(), (bool) $this->getPlaceholder()],
            default => [$this->format($state), false],
        };

        return [
            'type' => $this->getType(),
            'label' => $this->getLabel(),
            'state' => $state,
            'placehold' => $placehold ?: null,
            'badge' => $this->isBadge(),
            'variant' => $this->getVariant(),
            'class' => $this->getClasses(),
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
