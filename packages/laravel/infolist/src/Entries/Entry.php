<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Core\Primitive;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\CanHaveAlias;
use Honed\Core\Concerns\CanHaveExtra;
use Honed\Core\Concerns\Transformable;
use Honed\Infolist\Contracts\Formatter;
use Illuminate\Database\Eloquent\Model;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Infolist\Entries\Concerns\HasState;
use Honed\Infolist\Entries\Concerns\CanBeBadge;
use Honed\Infolist\Entries\Concerns\HasClasses;
use Honed\Infolist\Formatters\DefaultFormatter;
use Honed\Infolist\Concerns\HasPlaceholder;
use Honed\Infolist\Entries\Concerns\CanFormatValues;

/**
 * @template TValue
 * @template TReturn
 * 
 * @extends \Honed\Core\Primitive<string, mixed>
 */
class Entry extends Primitive implements NullsAsUndefined, Formatter
{
    use Allowable;
    use CanBeBadge;
    use HasClasses;
    use HasPlaceholder;
    use HasState;
    use HasLabel;
    use HasType;
    use HasName;
    use CanHaveAlias;
    use CanHaveExtra;
    use Transformable;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'column';

    /**
     * The formatter for the entry.
     *
     * @var Formatter<TValue, TReturn>|null
     */
    protected $formatter;

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

        return $this->getFormatter()->{$method}(...$parameters);
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
     * Apply the entry to the value.
     *
     * @param  TValue  $value
     * @return array{string|TReturn, bool}
     */
    public function apply($value): array
    {
        $value = $this->transform($value);

        return match (true) {
            is_null($value) => [$this->getPlaceholder(), (bool) $this->getPlaceholder()],
            default => [$this->format($value), false],
        };
    }

    /**
     * Set the formatter for the entry.
     *
     * @param class-string<Formatter<TValue, TReturn>>|Formatter<TValue, TReturn> $formatter
     * @return static
     */
    public function formatter(string|Formatter $formatter): static
    {
        $this->formatter = is_string($formatter) ? resolve($formatter) : $formatter;

        return $this;
    }

    /**
     * Get the formatter for the entry.
     *
     * @return Formatter<TValue, TReturn>
     */
    public function getFormatter(): Formatter
    {
        return $this->formatter ??= new DefaultFormatter();
    }

    /**
     * Format the value of the entry.
     *
     * @param TValue $value
     * @return TReturn
     */
    public function format(mixed $value): mixed
    {
        return $this->getFormatter()->format($value);
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
