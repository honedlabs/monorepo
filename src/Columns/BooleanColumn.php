<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

use Honed\Table\Columns\Concerns\Formatters\FormatsBoolean;

class BooleanColumn extends BaseColumn
{
    use FormatsBoolean;

    public function setUp(): void
    {
        $this->setType('boolean');
        $this->boolean();
    }

    public function apply(mixed $value): mixed
    {
        $value = $this->applyTransform($value);

        return $this->formatBoolean($value);
    }
}
