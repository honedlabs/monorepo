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
    use Concerns\CanFormatValues;
    use Concerns\HasClasses;
    use Concerns\HasPlaceholder;
    use Concerns\HasState;
    use HasLabel;
    use HasType;

    /**
     * Create a new list entry.
     *
     * @param  string|Closure|null  $state
     * @param  string|null  $label
     * @return static
     */
    public static function make($state = null, $label = null)
    {
        $label ??= is_string($state) ? static::makeLabel($state) : null;

        return resolve(static::class)
            ->state($state)
            ->label($label);
    }

    /**
     * Get the representation of the instance.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        $state = $this->getState();

        [$state, $placehold] = $this->apply($state);

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
     * @return array<int, mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        return match ($parameterName) {
            'state' => [$this->getState()],
            'model', 'record', 'row' => [$this->getRecord()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * Provide a selection of default dependencies for evaluation by type.
     *
     * @param  class-string  $parameterType
     * @return array<mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType(string $parameterType): array
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
