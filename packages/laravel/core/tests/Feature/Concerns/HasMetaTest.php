<?php

use Honed\Core\Concerns\HasMeta;

beforeEach(function () {
    $this->test = new class()
    {
        use HasMeta;
    };
});

it('sets', function () {
    expect($this->test)
        ->getMeta()->toBeNull()
        ->hasMeta()->toBeFalse()
        ->meta(['name' => 'test'])->toBe($this->test)
        ->getMeta()->toBe(['name' => 'test'])
        ->hasMeta()->toBeTrue();
});
