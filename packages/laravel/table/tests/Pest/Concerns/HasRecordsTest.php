<?php

declare(strict_types=1);

use Honed\Table\Concerns\HasRecords;

class HasRecordsTest
{
    use HasRecords;
}

beforeEach(function () {
    HasRecordsTest::reduceRecords(false);
    $this->test = new HasRecordsTest();
});

it('has no records by default', function () {
    expect($this->test)
        ->hasRecords()->toBeFalse()
        ->getRecords()->toBeNull();
});

it('can set records', function () {
    $this->test->setRecords(collect([1, 2, 3]));
    expect($this->test)
        ->hasRecords()->toBeTrue()
        ->getRecords()->toBeCollection([1, 2, 3]);
});

it('can configure whether to reduce records', function () {
    HasRecordsTest::reduceRecords(true);

    expect($this->test)
        ->isReducing()->toBeTrue();
});

it('is not reducing by default', function () {
    expect($this->test)
        ->isReducing()->toBeFalse();
});

describe('formatting', function () {
    beforeEach(function () {
        $this->columns = collect();
    });
    
    it('formats records using columns', function () {
    
    })->todo();
});