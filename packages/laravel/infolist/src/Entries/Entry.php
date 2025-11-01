<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use BackedEnum;
use BadMethodCallException;
use Closure;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasAlias;
use Honed\Core\Concerns\HasExtra;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasRecord;
use Honed\Core\Concerns\HasType;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;
use Honed\Infolist\Concerns\HasClasses;
use Honed\Infolist\Concerns\HasFormatter;
use Honed\Infolist\Concerns\HasPlaceholder;
use Honed\Infolist\Contracts\Entryable;
use Honed\Infolist\Contracts\Formatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @template TValue
 * @template TReturn
 *
 * @implements Formatter<TValue, TReturn>
 */
class Entry extends Primitive implements Entryable, Formatter, NullsAsUndefined
{
    use Allowable;
    use ForwardsCalls;
    use HasAlias;
    use HasClasses;
    use HasExtra;

    /**
     * @use HasFormatter<TValue, TReturn>
     */
    use HasFormatter;

    use HasLabel;
    use HasName;
    use HasPlaceholder;
    use HasRecord;
    use HasType;

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
    protected $badge;

    /**
     * The variant of the badge.
     *
     * @var string|BackedEnum|(Closure(mixed...):(string|BackedEnum|null))|null
     */
    protected $variant;

    /**
     * The before formatting callback.
     *
     * @var (Closure(mixed):TValue)|null
     */
    protected $before;

    /**
     * The after formatting callback.
     *
     * @var (Closure(TReturn):mixed)|null
     */
    protected $after;

    /**
     * The retrieval method.
     *
     * @var string|(Closure(mixed...):mixed)|null
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
     * @throws BadMethodCallException
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
        $this->badge = $value ?: null;

        return $this;
    }

    /**
     * Determine if the entry should be displayed as a badge.
     *
     * @return true|null
     */
    public function isBadge(): ?bool
    {
        return $this->badge;
    }

    /**
     * Set the variant of the badge.
     *
     * @param  string|BackedEnum|(Closure(mixed...):(string|BackedEnum|null))  $value
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
     * @param  string|(Closure(mixed...):mixed)  $state
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
     * @return string|(Closure(mixed...):mixed)|null
     */
    public function getStateResolver(): string|Closure|null
    {
        return $this->state ??= $this->getName();
    }

    /**
     * Get the resolved state of the entry.
     */
    public function getState(): mixed
    {
        return $this->resolved ??= $this->resolveState();
    }

    /**
     * Register a callback to be called before the entry is formatted.
     *
     * @param  Closure(mixed):TValue  $callback
     */
    public function beforeFormatting(Closure $callback): static
    {
        $this->before = $callback;

        return $this;
    }

    /**
     * Register a callback to be called after the entry is formatted.
     *
     * @param  Closure(TReturn):mixed  $callback
     */
    public function afterFormatting(Closure $callback): static
    {
        $this->after = $callback;

        return $this;
    }

    /**
     * Apply the entry to the value.
     *
     * @param  TValue  $value
     * @return array{scalar|TReturn|null, bool}
     */
    public function apply(mixed $value): array
    {
        $before = $this->callBeforeFormatting($value);

        return match (true) {
            is_null($before) => [$this->getPlaceholder(), true],
            default => [$this->callAfterFormatting($this->format($before)), false],
        };
    }

    /**
     * Populate the entry for the record.
     *
     * @param  array<string, mixed>|Model  $record
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
     * Convert the class to an entry.
     *
     * @return array<string, mixed>
     */
    public function entry(): array
    {
        return $this->toArray();
    }

    /**
     * Resolve the state of the entry.
     *
     * @return mixed
     */
    protected function resolveState()
    {
        $record = $this->getRecord();
        $resolver = $this->getStateResolver();

        return $this->resolved = match (true) {
            is_null($record) => null,
            is_string($resolver) => Arr::get($record, $resolver),
            is_callable($resolver) => $this->evaluate($resolver),
            default => null,
        };
    }

    /**
     * Call the before callback.
     *
     * @return TValue
     */
    protected function callBeforeFormatting(mixed $value): mixed
    {
        if (! $this->before) {
            /** @var TValue */
            return $value;
        }

        return ($this->before)($value);
    }

    /**
     * Call the after callback.
     *
     * @param  TReturn  $value
     */
    protected function callAfterFormatting(mixed $value): mixed
    {
        if (! $this->after || is_null($value)) {
            /** @var TReturn */
            return $value;
        }

        return ($this->after)($value);
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
