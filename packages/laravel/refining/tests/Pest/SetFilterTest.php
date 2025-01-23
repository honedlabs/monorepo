<?php

declare(strict_types=1);

use Honed\Refining\Tests\Stubs\Product;
use Honed\Refining\Filters\SetFilter;
use Honed\Refining\Tests\Stubs\Status;

beforeEach(function () {
    $this->builder = Product::query();
    $this->param = 'status';
    $this->filter = SetFilter::make($this->param);
});


it('filters with options', function () {
    // dd(Status::cases());

    $this->filter->options([
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ]);

    // dd($this->filter->getOptions());
});

// it('')