<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

use function implode;
use function is_null;

use function is_array;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Arrayable;
use Honed\Infolist\Entries\Concerns\CanBeArray;

class ArrayColumn extends Column
{
    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->type(self::ARRAY);
    }

    /**
     * Format the value of the entry.
     *
     * @param  array<int, mixed>|\Illuminate\Support\Collection<int, mixed>|null  $value
     * @return array<int, mixed>|string|null
     */
    public function format($value)
    {
        return is_null($value) ? null : $this->formatArray($value);
    }
}
