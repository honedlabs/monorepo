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
        ->hasScope()->toBeFalse()
        ->scope('scope')->toBe($this->test)
        ->getScope()->toBe('scope')
        ->hasScope()->toBeTrue()
        ->dontScope()->toBe($this->test)
        ->getScope()->toBeNull();
});

it('formats', function () {
    expect($this->test)
        ->formatScope('test')->toBe('test')
        ->hasScope()->toBeFalse()
        ->scope('scope')->toBe($this->test)
        ->formatScope('test')->toBe('scope:test')
        ->hasScope()->toBeTrue();
});

it('decodes', function () {
    expect($this->test)
        ->decodeScope('scope:test')->toBe('scope:test')
        ->scope('scope')->toBe($this->test)
        ->decodeScope('scope:test')->toBe('test');
});
