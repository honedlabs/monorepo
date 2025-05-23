<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasAlias;

beforeEach(function () {
    $this->test = new class {
        use HasAlias;
    };
});

it('accesses', function () {
    expect($this->test)
        ->defineAlias()->toBeNull()
        ->hasAlias()->toBeFalse()
        ->getAlias()->toBeNull()
        ->alias('test')->toBe($this->test)
        ->getAlias()->toBe('test')
        ->hasAlias()->toBeTrue();
});

it('defines', function () {
    $test = new class {
        use HasAlias;

        public function defineAlias()
        {
            return 'test';
        }
    };

    expect($test)
        ->hasAlias()->toBeTrue()
        ->getAlias()->toBe('test');
});
