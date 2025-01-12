<?php

declare(strict_types=1);

use Honed\Action\Creator;
use Honed\Action\InlineAction;

beforeEach(function () {
    $this->test = InlineAction::make('test');
});

it('makes', function () {
    expect($this->test)
        ->toBeInstanceOf(InlineAction::class);
});

it('has array representation', function () {
    expect($this->test->toArray())
        ->toBeArray()
        ->toHaveKeys(['name', 'label', 'type', 'icon', 'extra', 'default', 'action']);
});