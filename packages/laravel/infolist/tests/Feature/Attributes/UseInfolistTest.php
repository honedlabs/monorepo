<?php

declare(strict_types=1);

use Honed\Infolist\Attributes\UseInfolist;
use Workbench\App\Infolists\UserInfolist;
use Workbench\App\Models\User;

it('has attribute', function () {
    $attribute = new UseInfolist(UserInfolist::class);

    expect($attribute)
        ->toBeInstanceOf(UseInfolist::class)
        ->infolistClass->toBe(UserInfolist::class);

    expect(User::class)
        ->toHaveAttribute(UseInfolist::class);
});
