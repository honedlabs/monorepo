<?php

namespace Honed\Table\Contracts;

interface ColumnContract
{
    public function apply(mixed $value);

    public function formatValue(mixed $value);
}
