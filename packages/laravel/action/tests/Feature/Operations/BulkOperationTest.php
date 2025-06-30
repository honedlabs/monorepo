<?php

declare(strict_types=1);

use Honed\Action\Operations\BulkOperation;

beforeEach(function () {
    $this->action = BulkOperation::make('test');
});

it('has array representation', function () {
    expect($this->action->toArray())
        ->toBeArray()
        ->toHaveKey('keep');
});
