<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasType;

beforeEach(function () {
    $this->test = new class {
        use HasType;
    };
});

it('accesses', function () {
    expect($this->test)
        ->defineType()->toBeNull()
        ->getType()->toBeNull()
        ->hasType()->toBeFalse()
        ->type('test')->toBe($this->test)
        ->getType()->toBe('test')
        ->hasType()->toBeTrue();
});

it('defines', function () {
    $test = new class {
        use HasType;

        public function defineType()
        {
            return 'type';
        }
    };

    expect($test)
        ->hasType()->toBeTrue()
        ->getType()->toBe('type');
});