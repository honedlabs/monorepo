<?php

declare(strict_types=1);

use Honed\Action\Creator;
use Honed\Action\Facades\Action;

it('accesses', function () {
    expect(Action::getFacadeRoot())
        ->toBeInstanceOf(Creator::class);
});
