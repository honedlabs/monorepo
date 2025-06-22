<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

use Illuminate\Support\Number;

use function is_null;
use function is_numeric;
use function number_format;

class NumberColumn extends Column
{
    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->type(self::NUMERIC);
    }

    /**
     * Format the value of the entry.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function format($value)
    {
        return is_null($value) ? null : $this->formatNumeric($value);
    }
}
