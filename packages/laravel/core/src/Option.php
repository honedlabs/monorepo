<?php

declare(strict_types=1);

namespace Honed\Core;

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
     * @param mixed $value
     * @param string $label
     */
    final public function __construct($value, $label = null)
    {
        $this->setValue($value);
        $this->setLabel($label ?? $this->makeLabel((string) $value));
    }

    /**
     * Make a new option class.
     * 
     * @param mixed $value
     * @param string $label
     * @return static
     */
    public static function make($value, $label = null)
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
