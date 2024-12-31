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
     * 
     */
    final public function __construct(mixed $value, string $label = null)
    {
        $this->setValue($value);
        $this->setLabel($label ?? $this->makeLabel($value));
    }

    /**
     * Create an option class
     */
    public static function make(mixed $value, string $label = null): static
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
