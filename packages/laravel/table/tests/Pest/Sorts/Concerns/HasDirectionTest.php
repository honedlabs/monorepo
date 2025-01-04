<?php

use Honed\Table\Sorts\Concerns\HasDirection;
use Honed\Table\Sorts\Sort;

class HasDirectionTest
{
    use HasDirection;
}

beforeEach(function () {
    HasDirectionTest::sortByAscending();
    $this->test = Sort::make('created_at');
});

it('has no direction by default', function () {
    expect($this->test)
        ->getDirection()->toBeNull()
        ->hasDirection()->toBeFalse();
});


it('sets direction', function () {
    $this->test->setDirection(Sort::Descending);
    expect($this->test)
        ->getDirection()->toBe(Sort::Descending)
        ->hasDirection()->toBeTrue();
});

it('chains direction', function () {
    expect($this->test->direction(Sort::Descending))->toBeInstanceOf(Sort::class)
        ->getDirection()->toBe(Sort::Descending)
        ->hasDirection()->toBeTrue();
});

it('rejects invalid directions', function () {
    $this->test->setDirection(Sort::Descending);
    $this->test->setDirection(null);
    expect($this->test)
        ->getDirection()->toBe(Sort::Descending)
        ->hasDirection()->toBeTrue();
});


it('has shorthand `desc`', function () {
    expect($this->test->desc())->toBeInstanceOf(Sort::class)
        ->getDirection()->toBe(Sort::Descending)
        ->hasDirection()->toBeTrue();
});

it('has shorthand `asc`', function () {
    expect($this->test->asc())->toBeInstanceOf(Sort::class)
        ->getDirection()->toBe(Sort::Ascending)
        ->hasDirection()->toBeTrue();
});

it('can be globally configured for descending', function () {
    HasDirectionTest::sortByDescending();
    expect($this->test->getDefaultDirection())->toBe(Sort::Descending);
});

it('can be globally configured for ascending', function () {
    HasDirectionTest::sortByAscending();
    expect($this->test->getDefaultDirection())->toBe(Sort::Ascending);
});

it('has no active direction by default', function () {
    expect($this->test->getActiveDirection())->toBeNull();
});

it('sets active direction', function () {
    $this->test->setActiveDirection(Sort::Descending);
    expect($this->test->getActiveDirection())->toBe(Sort::Descending);
});

it('checks if is agnostic', function () {
    expect($this->test->isAgnostic())->toBeTrue();
});

it('checks if is not agnostic', function () {
    $this->test->setActiveDirection(Sort::Descending);
    expect($this->test->isAgnostic())->toBeFalse();
});
