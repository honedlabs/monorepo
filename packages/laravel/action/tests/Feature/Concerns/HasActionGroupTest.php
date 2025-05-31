<?php

declare(strict_types=1);

use Workbench\App\Models\User;
use Workbench\App\ActionGroups\UserActions;

it('has action group', function () {
    expect(User::actions())
        ->toBeInstanceOf(UserActions::class);
});
