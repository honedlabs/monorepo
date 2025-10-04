<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Closure;
use BackedEnum;
use Honed\Core\Primitive;
use Illuminate\Support\Arr;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasRecord;
use Honed\Core\Concerns\CanHaveAlias;
use Honed\Core\Concerns\CanHaveExtra;
use Honed\Infolist\Concerns\HasState;
use Honed\Core\Concerns\Transformable;
use Honed\Infolist\Concerns\CanBeBadge;
use Honed\Infolist\Concerns\HasClasses;
use Honed\Infolist\Contracts\Formatter;
use Illuminate\Database\Eloquent\Model;
use Honed\Infolist\Concerns\HasFormatter;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Infolist\Concerns\HasPlaceholder;
use Honed\Infolist\Formatters\DefaultFormatter;
use Honed\Infolist\Entries\Concerns\CanFormatValues;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @template TValue
 * @template TReturn
 * 
 * @extends \Honed\Core\Primitive<string, mixed>
 * 
 * @implements Formatter<TValue, TReturn>
 */
class Entry extends Primitive implements NullsAsUndefined, Formatter
{
    use Allowable;
    use HasClasses;
    use HasPlaceholder;
    use HasLabel;
    use HasType;
    use HasName;
    use CanHaveAlias;
    use CanHaveExtra;
    use Transformable;
    use HasRecord;
    use ForwardsCalls;

    /**
     * @use HasFormatter<TValue, TReturn>
     */
    use HasFormatter;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'entry';

    /**
     * Whether the entry should be displayed as a badge.
     *
     * @var true|null
     */
    protected $isBadge;

    /**
     * The variant of the badge.
     *
     * @var string|\BackedEnum|(\Closure(mixed...):(string|\BackedEnum|null))|null
     */
    protected $variant;

    /**
     * The retrieval method.
     *
     * @var string|(\Closure(mixed...):mixed)|null
     */
    protected $state;

    /**
     * The resolved value.
     *
     * @var mixed
     */
    protected $resolved;

    /**
     * Handle dynamic method calls into the instance.
     *
     * @param  string  $method
     * @param  array<int, mixed>  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return parent::macroCall($method, $parameters);
        }

        return $this->forwardDecoratedCallTo($this->getFormatter(), $method, $parameters);
    }

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
     * Set whether the entry should be displayed as a badge.
     *
     * @return $this
     */
    public function badge(bool $value = true): static
    {
        $this->isBadge = $value ?: null;

        return $this;
    }

    /**
     * Determine if the entry should be displayed as a badge.
     *
     * @return true|null
     */
    public function isBadge(): ?bool
    {
        return $this->isBadge;
    }

    /**
     * Set the variant of the badge.
     *
     * @param   string|\BackedEnum|(\Closure(mixed...):(string|\BackedEnum|null))  $value
     * @return $this
     */
    public function variant(mixed $value): static
    {
        $this->variant = $value;

        return $this;
    }

    /**
     * Get the variant of the badge.
     */
    public function getVariant(): string|BackedEnum|null
    {
        if (! $this->isBadge()) {
            return null;
        }

        return $this->evaluate($this->variant);
    }

    /**
     * Set how the state of the entry is generated.
     *
     * @param  string|(\Closure(mixed...):mixed)  $state
     * @return $this
     */
    public function state(string|Closure $state): static
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the state of the entry.
     *
     * @return string|(\Closure(mixed...):mixed)|null
     */
    public function getStateResolver(): string|Closure|null
    {
        return $this->state;
    }

    /**
     * Get the resolved state of the entry.
     *
     * @return mixed
     */
    public function getState(): mixed
    {
        return $this->resolved ??= $this->resolveState();
    }

    /**
     * Apply the entry to the value.
     *
     * @param  TValue  $value
     * @return array{scalar|TReturn|null, bool}
     */
    public function apply(mixed $value): array
    {
        $value = $this->transform($value);

        return match (true) {
            is_null($value) => [$this->getPlaceholder(), true],
            default => [$this->format($value), false],
        };
    }

    /**
     * Populate the entry for the record.
     * 
     * @param array<string, mixed>|Model $record
     * @return array<string, mixed>
     */
    public function generate(array|Model $record): array
    {
        return $this->record($record)->populate();
    }

    /**
     * Populate the entry for the record.
     *
     * @return array<string, mixed>
     */
    public function populate(): array
    {
        if (! $this->getState()) {
            $this->state($this->getName());
        }

        [$value, $placeholder] = $this->apply($this->resolveState());

        return $this->undefine([
            'v' => $value,
            'e' => $this->getExtra(),
            'c' => $this->getClasses(),
            'f' => $placeholder,
            'a' => $this->getVariant(),
        ]);
    }

    /**
     * Resolve the state of the entry.
     *
     * @return mixed
     */
    protected function resolveState()
    {
        $record = $this->getRecord();

        return $this->resolved = match (true) {
            is_null($record) => null,
            is_string($this->state) => Arr::get($record, $this->state),
            is_callable($this->state) => $this->evaluate($this->state),
            default => null,
        };
    }

    /**
     * Get the representation of the instance.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        $this->define();

        return [
            'name' => $this->getParameter(),
            'label' => $this->getLabel(),
            'type' => $this->getType(),
            'value' => $this->populate(),
            'badge' => $this->isBadge(),
            'class' => $this->getClasses(),
            // 'attributes' => 
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
            'state', 'value' => [$this->getState()],
            'model', 'record', 'row' => [$this->getRecord()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * Provide a selection of default dependencies for evaluation by type.
     *
     * @param  class-string  $parameterType
     * @return array<int, mixed>
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
