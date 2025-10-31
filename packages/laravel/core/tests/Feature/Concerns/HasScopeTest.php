<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasScope;

beforeEach(function () {
    $this->test = new class()
    {
        use HasScope;
    };
});

it('sets', function () {
    expect($this->test)
        ->getScope()->toBeNull()
        ->scope('scope')->toBe($this->test)
        ->getScope()->toBe('scope')
        ->dontScope()->toBe($this->test)
        ->getScope()->toBeNull();
});

it('scopes', function () {
    expect($this->test)
        ->getScope()->toBeNull();

    expect($this->test->scoped('test'))->toBe('test');
    expect($this->test->scope('scope')->scoped('test'))->toBe('scope:test');
});

it('unscopes', function () {
    expect($this->test)
        ->unscoped('scope:test')->toBe('scope:test');

    $this->test->scope('scope');

    expect($this->test)
        ->unscoped('scope:test')->toBe('test')
        ->unscoped('scope:test:value')->toBe('test:value')
        ->unscoped('test:scope:value')->toBe('value');
});
