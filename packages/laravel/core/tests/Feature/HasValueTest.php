<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasValue;

beforeEach(function () {
    $this->test = new class {
        use HasValue;
    };
});

it('accesses', function () {
    expect($this->test)
        ->defineValue()->toBeNull()
        ->getValue()->toBeNull()
        ->hasValue()->toBeFalse()
        ->value('test')->toBe($this->test)
        ->getValue()->toBe('test')
        ->hasValue()->toBeTrue();
});

it('defines', function () {
    $test = new class {
        use HasValue;
        
        public function defineValue()
        {
            return 'test';
        }
    };

    expect($test)
        ->hasValue()->toBeTrue()
        ->getValue()->toBe('test');
});