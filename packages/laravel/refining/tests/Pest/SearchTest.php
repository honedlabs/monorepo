<?php

declare(strict_types=1);

use Honed\Refining\Searches\Search;
use Honed\Refining\Tests\Stubs\Product;
use Illuminate\Support\Facades\Request;

beforeEach(function () {
    $this->builder = Product::query();
    $this->param = 'name';
    $this->search = Search::make($this->param);
});