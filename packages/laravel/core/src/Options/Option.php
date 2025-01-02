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
     * 
     * @param string|\Closure():string $value
     */
    final public function __construct(string|\Closure $value, string|\Closure $label = null)
    {
        $this->setValue($value);
        $this->setLabel($label ?? $this->makeLabel($value));
    }

    /**
     * Make a new option class.
     * 
     * @param string|\Closure():string $value
     */
    public static function make(string|\Closure $value, string $label = null): static
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
