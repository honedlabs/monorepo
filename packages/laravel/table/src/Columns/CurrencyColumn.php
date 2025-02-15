<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

class CurrencyColumn extends Column
{
    public function setUp(): void
    {
        parent::setUp();

        $this->type('currency');
        $this->formatNumeric(
            locale: config('app.locale'),
            currency: config('app.currency'),
        );
    }
}
