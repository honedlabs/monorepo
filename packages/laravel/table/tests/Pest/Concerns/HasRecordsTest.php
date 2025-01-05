<?php

declare(strict_types=1);

use Honed\Table\Concerns\HasRecords;

class HasRecordsTest
{
    use HasRecords;
}

beforeEach(function () {
    $this->test = new HasRecordsTest();
});

it('has no records by default', function () {
    expect($this->test)
        ->hasRecords()->toBeFalse();
});

it('can set records', function () {
    $this->test->setRecords(collect([1, 2, 3]));

    expect($this->test)->hasRecords()->toBeTrue();
})->todo();

it('formats records using columns', function () {

})->todo();

it('paginates records', function () {

})->todo();
