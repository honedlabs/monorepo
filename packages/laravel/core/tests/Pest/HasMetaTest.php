<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasMeta;

beforeEach(function () {
    $this->test = new class {
        use HasMeta;
    };
});

it('accesses', function () {
    expect($this->test)
        ->getMeta()->toBeEmpty()
        ->hasMeta()->toBeFalse()
        ->meta(['name' => 'test'])->toBe($this->test)
        ->getMeta()->toBe(['name' => 'test'])
        ->hasMeta()->toBeTrue();
});