<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasContainer;
use Illuminate\Contracts\Container\Container;

beforeEach(function () {
    $this->test = new class()
    {
        use HasContainer;
    };
});

it('sets', function () {
    expect($this->test)
        ->container(app(Container::class))->toBe($this->test)
        ->getContainer()->toBeInstanceOf(Container::class);
});
