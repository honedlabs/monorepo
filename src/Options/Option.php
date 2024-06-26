<?php

namespace Vanguard\Core\Options;

use Closure;
use Vanguard\Core\Concerns\HasLabel;
use Vanguard\Core\Concerns\HasMetadata;
use Vanguard\Core\Concerns\HasValue;
use Vanguard\Core\Concerns\IsActive;
use Vanguard\Core\Options\Contracts\Options;
use Vanguard\Core\Primitive;

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
        return new static($value, $label, $metadata);
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