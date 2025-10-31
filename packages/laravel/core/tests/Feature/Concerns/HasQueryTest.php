<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasQuery;

beforeEach(function () {
    $this->test = new class()
    {
        use Evaluable, HasQuery;
    };
});

it('sets', function () {
    expect($this->test)
        ->queryCallback()->toBeNull()
        ->query(fn () => null)->toBe($this->test)
        ->queryCallback()->toBeInstanceOf(Closure::class);
});

it('calls', function () {
    $this->test->query(fn () => 'test');

    expect($this->test->callQuery())->toBe('test');
});
