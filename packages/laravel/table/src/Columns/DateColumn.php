<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

class DateColumn extends BaseColumn
{
    public function setUp(): void
    {
        $this->setType('col:date');
        $this->date();
    }
}
