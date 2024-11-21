<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

class KeyColumn extends BaseColumn
{
    public function setUp(): void
    {
        $this->setType('key');
        $this->setKey(true);
    }

    public function apply(mixed $value): mixed
    {
        return $value;
    }
}
