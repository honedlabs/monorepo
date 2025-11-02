<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Carbon\Carbon;
use Honed\Form\Concerns\HasDateFormat;
use Honed\Form\Enums\FormComponent;
use Honed\Form\Enums\Granularity;

class DateField extends Field
{
    use HasDateFormat;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'dateField';

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
    public function granularity(string|Granularity $value): static
    {
        return $this->attribute('granularity', is_string($value) ? $value : $value->value);
    }

    /**
     * Set the locale of the date.
     *
     * @return $this
     */
    public function locale(string $value): static
    {
        return $this->attribute('locale', $value);
    }
}
