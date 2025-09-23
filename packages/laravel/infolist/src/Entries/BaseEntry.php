<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Closure;
use Honed\Core\Primitive;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\CanHaveAlias;
use Honed\Core\Concerns\CanHaveExtra;
use Illuminate\Database\Eloquent\Model;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Infolist\Entries\Concerns\HasState;
use Honed\Infolist\Entries\Concerns\CanBeBadge;
use Honed\Infolist\Entries\Concerns\HasClasses;
use Honed\Infolist\Entries\Concerns\HasPlaceholder;
use Honed\Infolist\Entries\Concerns\CanFormatValues;

/**
 * @extends \Honed\Core\Primitive<string, mixed>
 */
abstract class BaseEntry extends Primitive implements NullsAsUndefined
{
    use Allowable;
    use CanBeBadge;
    use CanFormatValues;
    use HasClasses;
    use HasPlaceholder;
    use HasState;
    use HasLabel;
    use HasType;
    use HasName;
    use CanHaveAlias;
    use CanHaveExtra;
    // use HasAttr;

    /**
     * Create a new list entry.
     */
    public static function make(string $name, ?string $label = null): static
    {
        return resolve(static::class)
            ->name($name)
            ->label($label ?? static::makeLabel($name));
    }

    /**
     * Get the parameter for the column.
     */
    public function getParameter(): string
    {
        return $this->getAlias()
            ?? str_replace('.', '_', $this->getName());
    }

    /**
     * Get the representation of the instance.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        $this->define();

        $state = $this->getState();

        [$state, $placehold] = $this->apply($state);

        return [
            'label' => $this->getLabel(),
            'type' => $this->getType(),
            'state' => $state,
            'placehold' => $placehold ?: null,
            'badge' => $this->isBadge(),
            'variant' => $this->getVariant(),
            'class' => $this->getClasses(),
        ];
    }

    /**
     * Get the entry for the record.
     * 
     * @param array<string, mixed>|Model $record
     * @return array<string, mixed>
     */
    protected function entry(array|Model $record): array
    {
        [$value, $placeholder] = $this->value($record);

        return $this->undefine([
            'v' => $value,
            'e' => $this->getExtra(),
            'c' => $this->getClasses(),
            'f' => $placeholder,
            'a' => $this->getVariant(),
        ]);
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
