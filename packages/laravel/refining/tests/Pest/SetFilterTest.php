<?php

declare(strict_types=1);

use Honed\Refining\Tests\Stubs\Product;
use Illuminate\Support\Facades\Request;
use Honed\Refining\Filters\SetFilter;

beforeEach(function () {
    $this->builder = Product::query();
    $this->param = 'is_active';
    $this->filter = SetFilter::make($this->param);
});


// it();