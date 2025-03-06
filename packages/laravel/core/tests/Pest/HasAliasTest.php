<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasAlias;

beforeEach(function () {
    $this->test = new class
    {
        use HasAlias;

        public function getAliasedName()
        {
            return $this->getAlias();
        }
    };
});

it('is null by default', function () {
    expect($this->test)
        ->hasAlias()->toBeFalse();
});

it('sets', function () {
    expect($this->test)
        ->alias('test')->toBe($this->test)
        ->hasAlias()->toBeTrue();
});

it('gets', function () {
    expect($this->test->alias('test'))
        ->getAlias()->toBe('test')
        ->hasAlias()->toBeTrue();
});
