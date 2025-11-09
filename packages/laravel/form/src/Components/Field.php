<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Closure;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasName;
use Honed\Form\Concerns\CanBeAutofocused;
use Honed\Form\Concerns\CanBeDisabled;
use Honed\Form\Concerns\CanBeOptional;
use Honed\Form\Concerns\CanBeRequired;
use Honed\Form\Concerns\HasHint;
use Honed\Form\Contracts\Defaultable;
use Illuminate\Support\Arr;

abstract class Field extends Component implements Defaultable
{
    use CanBeAutofocused;
    use CanBeDisabled;
    use CanBeOptional;
    use CanBeRequired;
    use HasHint;
    use HasLabel;
    use HasName;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'field';

    /**
     * The value of the component.
     *
     * @var mixed
     */
    protected $value;

    /**
     * How the value of the component is resolved.
     *
     * @var non-empty-string|Closure|null
     */
    protected $using;

    /**
     * The default value.
     *
     * @var mixed
     */
    protected $defaultValue;

    /**
     * Create a new field instance.
     */
    public static function make(string $name, ?string $label = null): static
    {
        return app(static::class)
            ->name($name)
            ->label($label ?? static::makeLabel($name));
    }

    /**
     * Set how to retrieve the value of the component from a record.
     *
     * @param  non-empty-string|Closure  $value
     * @return $this
     */
    public function using(string|Closure $value): static
    {
        $this->using = $value;

        return $this;
    }

    /**
     * Set the default value.
     *
     * @return $this
     */
    public function defaultValue(mixed $value): static
    {
        $this->defaultValue = $value;

        return $this;
    }

    /**
     * Get the placeholder for when the given value is null.
     */
    public function empty(): mixed
    {
        return null;
    }

    /**
     * Get the default value.
     */
    public function getDefaultValue(): mixed
    {
        return $this->defaultValue ?? $this->empty();
    }

    /**
     * Get the value of the component.
     */
    public function getValue(): mixed
    {
        $record = $this->getRecord();

        if ($record === null) {
            return $this->getDefaultValue();
        }

        $getter = $this->using ?? $this->getName();

        return $this->value = match (true) {
            is_string($getter) => Arr::get($record, $getter),
            is_callable($getter) => $this->evaluate($getter),
        };
    }

    /**
     * Set a minimum attribute on the field.
     *
     * @return $this
     */
    public function min(mixed $value): static
    {
        return $this->attribute('min', $value);
    }

    /**
     * Set a maximum attribute on the field.
     *
     * @return $this
     */
    public function max(mixed $value): static
    {
        return $this->attribute('max', $value);
    }

    /**
     * Get the array representation of the form field.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'hint' => $this->getHint(),
            'defaultValue' => $this->getValue(),
            'required' => $this->isRequired() ?: null,
            'disabled' => $this->isDisabled() ?: null,
            'optional' => $this->isOptional() ?: null,
            'autofocus' => $this->isAutofocused() ?: null,
        ];
    }
}
