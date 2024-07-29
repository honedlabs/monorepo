<?php

namespace Workbench\App;

use Conquest\Core\Concerns\RequiresKey;

use Conquest\Core\Primitive;

class KeyComponent extends Primitive
{
    use RequiresKey;

    public function key()
    {
        return 'id';
    }

    public function make(): static
    {
        return resolve(static::class);
    }

    public function toArray()
    {
        return [
            'id' => $this->getKey(),
        ];
    }
}
