<?php

declare(strict_types=1);

namespace Honed\Refining\Filters\Concerns;

use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Concerns\IsActive;
use Honed\Core\Primitive;
use Illuminate\Contracts\Support\Arrayable;

class Option extends Primitive
{
    use HasValue;
    use HasLabel;
    use IsActive;

    public function __construct(
        mixed $value,
        string $label = null,
    ) {
        $this->value($value);
        $this->label($label ?? $this->makeLabel((string) $value));
    }

    /**
     * @return $this
     */
    public static function make(
        mixed $value,
        string $label = null,
    ): static {
        return resolve(static::class, \compact('value', 'label'));
    }

    public function toArray(): array
    {
        return [
            'value' => $this->getValue(),
            'label' => $this->getLabel(),
            'active' => $this->isActive(),
        ];
    }
}