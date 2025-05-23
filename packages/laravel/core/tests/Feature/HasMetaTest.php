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
        ->defineMeta()->toEqual([])
        ->getMeta()->toEqual([])
        ->hasMeta()->toBeFalse()
        ->meta(['name' => 'test'])->toBe($this->test)
        ->getMeta()->toBe(['name' => 'test'])
        ->hasMeta()->toBeTrue();
});

it('defines', function () {
    $test = new class {
        use HasMeta;

        public function defineMeta()
        {
            return ['name' => 'test'];
        }
    };

    expect($test)
        ->getMeta()->toEqual(['name' => 'test'])
        ->hasMeta()->toBeTrue();
});