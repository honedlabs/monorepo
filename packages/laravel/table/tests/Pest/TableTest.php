<?php

declare(strict_types=1);

use Honed\Table\Table as HonedTable;
use Honed\Table\Tests\Fixtures\Table;


beforeEach(function () {
    $this->test = Table::make();
});


it('can be made', function () {
    expect($this->test)
        ->toBeInstanceOf(HonedTable::class);
});

it('has array representation', function () {
    expect($this->test)
        ->toArray()
        ->toBeArray()
        ->toHaveKeys([
            'id',
            'key',
            'records',
            'columns',
            'actions',
            'filters',
            'sorts',
            'paginator',
            'toggleable',
            'sort',
            'order',
            'count',
            'search',
            'toggle',
            'endpoint',
        ]);
})->skip();

it('accepts a request to use', function () {
    // $this->test->build(request());
    dd($this->test->toArray());
});
