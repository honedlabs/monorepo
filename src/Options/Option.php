<?php

namespace Honed\Core\Options;

use Closure;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Concerns\IsActive;
use Honed\Core\Options\Contracts\Options;
use Honed\Core\Primitive;

/**
 * Class for a single option.
 */
class Option extends Primitive implements Options
{
    use HasLabel;
    use HasMeta;
    use HasValue;
    use IsActive;

    public function __construct(
        mixed $value,
        ?string $label = null,
        array|Closure|null $meta = null
    ) {
        $this->setValue($value);
        $this->setLabel($label ?? $this->toLabel($value));
        $this->setMeta($meta);
    }

    /**
     * Make a new option.
     */
    public static function make(
        mixed $value,
        ?string $label = null,
        array|Closure|null $meta = null
    ): static {
        return resolve(static::class, compact('value', 'label', 'meta'));
    }

    public function toArray(): array
    {
        return [
            'value' => $this->getValue(),
            'label' => $this->getLabel(),
            'meta' => $this->getMeta(),
            'active' => $this->isActive(),
        ];
    }
}
