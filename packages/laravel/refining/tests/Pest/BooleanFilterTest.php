<?php

declare(strict_types=1);

use Honed\Refining\Filters\BooleanFilter;
use Honed\Refining\Tests\Stubs\Product;

it('filters by boolean value', function () {
    dd(\filter_var('tru', \FILTER_VALIDATE_BOOLEAN, \FILTER_NULL_ON_FAILURE));
});

