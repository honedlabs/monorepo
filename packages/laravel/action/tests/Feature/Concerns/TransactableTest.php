<?php

declare(strict_types=1);

use Honed\Action\Actions\Concerns\Transactable;

beforeEach(function () {
    $this->test = new class()
    {
        use Transactable;
    };
})->only();

afterEach(function () {
    config()->set('action.transact', false);
});

it('can transact', function () {
    expect($this->test)
        ->isNotTransaction()->toBeTrue()
        ->isTransaction()->toBeFalse()
        ->transact()->toBe($this->test)
        ->isTransaction()->toBeTrue()
        ->dontTransact()->toBe($this->test)
        ->isNotTransaction()->toBeTrue();
});

it('can transact ', function () {
    $this->test->withinTransaction();

    expect($this->test)
        ->isTransaction()->toBeTrue();

    $this->test->outsideTransaction();

    expect($this->test)
        ->isTransaction()->toBeFalse()
        ->transact()->toBe($this->test)
        ->isTransaction()->toBeTrue();
});
