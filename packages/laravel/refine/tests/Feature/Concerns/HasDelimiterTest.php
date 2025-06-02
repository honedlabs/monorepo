<?php

namespace Honed\Refine\Tests\Feature\Concerns;

use Honed\Refine\Concerns\HasDelimiter;
use Honed\Refine\Tests\TestCase;

beforeEach(function () {
    $this->test = new class()
    {
        use HasDelimiter;
    };

    $this->test::useDelimiter();
});

it('sets', function () {
    expect($this->test)
        ->getDelimiter()->toBe(',')
        ->delimiter('|')->toBe($this->test)
        ->getDelimiter()->toBe('|');
});

it('sets global delimiter', function () {
    $this->test::useDelimiter('|');

    expect($this->test->getDelimiter())->toBe('|');
});
