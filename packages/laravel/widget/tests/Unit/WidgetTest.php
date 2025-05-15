<?php

declare(strict_types=1);

use Workbench\App\Models\User;

it('tests', function () {
    dd(User::query()->get());
    expect(true)->toBeTrue();
});
