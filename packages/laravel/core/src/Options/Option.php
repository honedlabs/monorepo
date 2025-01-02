<?php

declare(strict_types=1);

namespace Honed\Core\Options;

use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Concerns\IsActive;
use Honed\Core\Primitive;

class Option extends Primitive
{
    use HasLabel;
    use HasMeta;
    use HasValue;
    use IsActive;

    /**
     * Create a new Option instance.
     */
    final public function __construct(int|string|float|bool|null $value, string|\Closure|null $label = null)
    {
        $this->setValue($value);
        $this->setLabel($label ?? $this->makeLabel((string) $value));
    }

    /**
     * Make a new option class.
     */
    public static function make(int|string|float|bool|null $value, ?string $label = null): static
    {
        return resolve(static::class, compact('value', 'label'));
    }

    public function toArray()
    {
        return [
            'value' => $this->getValue(),
            'label' => $this->getLabel(),
            'meta' => $this->getMeta(),
            'active' => $this->isActive(),
        ];
    }
}
