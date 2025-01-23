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
        string $value,
        string $label,
        bool $active = true,
    ) {
        $this->value($value);
        $this->label($label ?? $this->makeLabel((string) $value));
        $this->active($active);
    }

    public static function make(string $value, string $label, bool $active = true): static
    {
        return resolve(static::class, \compact('value', 'label', 'active'));
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