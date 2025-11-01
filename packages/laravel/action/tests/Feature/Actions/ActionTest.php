<?php

declare(strict_types=1);

use Honed\Action\Actions\Action;
use Honed\Action\Actions\UpdateAction;
use Illuminate\Contracts\Container\Container;

it('resolves action', function () {
    expect(UpdateAction::make())
        ->toBeInstanceOf(UpdateAction::class);
});