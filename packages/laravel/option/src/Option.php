<?php

declare(strict_types=1);

namespace Honed\Option;

use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Contracts\HasLabel as HasLabelContract;
use Honed\Core\SimplePrimitive;

/**
 * @extends SimplePrimitive<string, mixed>
 */
class Option extends SimplePrimitive
{
    use HasLabel;
    use HasValue;

    /**
     * Create a new option.
     *
     * @param  scalar|null  $value
     */
    public static function make(
        mixed $value,
        string|HasLabelContract|null $label = null
    ): static {

        return resolve(static::class)
            ->value($value)
            ->label($label ?? static::makeLabel((string) $value));
    }

    /**
     * Get the label.
     */
    public function getLabel(): ?string
    {
        return $this->label; // @phpstan-ignore-line
    }

    /**
     * Get the representation of the option.
     */
    protected function representation(): array
    {
        return [
            'value' => $this->value,
            'label' => $this->label,
        ];
    }
}
