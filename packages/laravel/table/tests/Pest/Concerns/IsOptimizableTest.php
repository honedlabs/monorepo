<?php

declare(strict_types=1);

use Honed\Table\Concerns\IsOptimizable;

class IsOptimizableTest
{
    use IsOptimizable;
}

beforeEach(function () {
    IsOptimizableTest::shouldOptimize(false);
    $this->test = new IsOptimizableTest;
});

it('is not `optimizable` by default', function () {
    expect($this->test->isOptimized())->toBeFalse();
});

it('sets optimizable', function () {
    $this->test->setOptimize(true);
    expect($this->test->isOptimized())->toBeTrue();
});

it('configures globally', function () {
    IsOptimizableTest::shouldOptimize(true);
    expect($this->test->isOptimized())->toBeTrue();
});

it('optimizes a query', function () {
    $this->test->optimize($this->builder);
})->todo();
