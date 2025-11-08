<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Carbon\Carbon;
use Honed\Form\Concerns\HasDateFormat;
use Honed\Form\Enums\FormComponent;

class DateField extends Field
{
    use HasDateFormat;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'date';

    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return FormComponent::Date;
    }

    /**
     * Get the value of the component.
     */
    public function getValue(): mixed
    {
        $value = parent::getValue();

        if ($value === null || $this->missingFormat()) {
            return $value;
        }

        // @phpstan-ignore-next-line
        return Carbon::parse($value)->format($this->getFormat());
    }

    /**
     * Set the granularity of the date.
     *
     * @return $this
     */
    public function granularity(string|BackedEnum|null $value): static
    {
        return $this->attribute('granularity', $value instanceof BackedEnum ? (string) $value->value : $value);
    }

    /**
     * Set the locale of the date.
     *
     * @return $this
     */
    public function locale(string|BackedEnum|null $value): static
    {
        return $this->attribute('locale', $value instanceof BackedEnum ? (string) $value->value : $value);
    }

    /**
     * Set the locale of the date to the application locale.
     *
     * @return $this
     */
    public function appLocale(): static
    {
        return $this->locale(app()->getLocale());
    }
}
