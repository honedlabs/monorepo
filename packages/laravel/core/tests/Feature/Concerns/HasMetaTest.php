<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasMeta;

beforeEach(function () {
    $this->test = new class()
    {
        use Evaluable, HasMeta;
    };
});

it('sets', function () {
    expect($this->test)
        ->getMeta()->toBe([])
        ->meta(['name' => 'test'])->toBe($this->test)
        ->getMeta()->toBe(['name' => 'test']);
});
