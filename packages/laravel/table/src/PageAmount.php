<?php

namespace Honed\Table;

use Honed\Core\Concerns\HasValue;
use Honed\Core\Concerns\IsActive;
use Honed\Core\Primitive;

class PageAmount extends Primitive
{
    use IsActive;
    use HasValue;

    public function __construct(int $value)
    {
        $this->setValue($value);
    }

    public static function make(int $value): static
    {
        return new static($value);
    }

    public function toArray(): array
    {
        return [
            'value' => $this->getValue(),
            'active' => $this->isActive(),
        ];
    }
}