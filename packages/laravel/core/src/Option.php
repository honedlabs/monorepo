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
     * Create a new option instance.
     * 
     * @param int|string|float|null $value
     * @param string $label
     */
    final public function __construct($value, $label = null)
    {
        $this->value($value);
        $this->label($label ?? $this->makeLabel((string) $value));
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
            'value' => $this->value(),
            'label' => $this->label(),
            'meta' => $this->meta(),
            'active' => $this->isActive(),
        ];
    }
}
