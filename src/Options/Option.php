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
     * @param int|string|array|\Closure():int|string|array $value
     * @param string|(\Closure():string)|null $label
     */
    final public function __construct(mixed $value, $label = null)
    {
        $this->setValue($value);
        $this->setLabel($label ?? $this->makeLabel($value));
    }

    /**
     * Create an option class
     * 
     * @param int|string|array|\Closure():int|string|array $value
     * @param string|(\Closure():string)|null $label
     */
    public static function make($value, $label = null): static
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
