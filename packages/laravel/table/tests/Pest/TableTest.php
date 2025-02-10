<?php

declare(strict_types=1);

use Honed\Table\Table as HonedTable;
use Honed\Table\Tests\Fixtures\Table;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->test = Table::make();

    foreach (\range(1, 100) as $i) {
        product();
    }
});

it('builds', function () {
    expect($this->test->buildTable())
        ->toBe($this->test)
        ->getPaginator()->toBe('length-aware')
        ->getMeta()->toHaveCount(10)
        ->getCookie()->toBe('example-table');
});

it('can be modified', function () {

});

// it('refines', function () {
//     expect($this->test->buildTable())
//         ->toBe($this->test)
//         ->getFilters()->toBe([]);
// });

// it('toggles', function () {
//     expect($this->test->buildTable())
//         ->toBe($this->test)
//         ->getColumns()->toBe([]);
// });

// it('actions', function () {
//     expect($this->test->buildTable())
//         ->toBe($this->test)
//         ->getActions()->toBe([]);
// });


