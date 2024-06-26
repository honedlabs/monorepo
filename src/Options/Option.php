<?php

namespace Conquest\Core\Options;

use Closure;
use Conquest\Core\Concerns\HasLabel;
use Conquest\Core\Concerns\HasMetadata;
use Conquest\Core\Concerns\HasValue;
use Conquest\Core\Concerns\IsActive;
use Conquest\Core\Options\Contracts\Options;
use Conquest\Core\Primitive;

/**
 * Class for a single option.
 */
class Option extends Primitive implements Options
{
    use HasLabel;
    use HasValue;
    use HasMetadata;
    use IsActive;

    public function __construct(
        mixed $value,
        string $label = null,
        array $metadata = null
    ) {
        $this->setValue($value);
        $this->setLabel($label ?? $this->toLabel($value));
        $this->setMetadata($metadata);
    }

    /**
     * Make a new option.
     * 
     * @param mixed $value
     * @param string|null $label
     * @param array|Closure|null $metadata
     */
    public static function make(
        mixed $value,
        string $label = null,
        array|Closure $metadata = null
    ): static {
        return resolve(static::class, compact('value', 'label', 'metadata'));
    }

    public function toArray(): array
    {
        return [
            'value' => $this->getValue(),
            'label' => $this->getLabel(),
            'metadata' => $this->getMetadata(),
            'active' => $this->isActive(),
        ];
    }
}