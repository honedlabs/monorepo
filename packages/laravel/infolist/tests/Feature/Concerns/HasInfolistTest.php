<?php

declare(strict_types=1);

use Workbench\App\Infolists\UserInfolist;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('has infolist via attribute', function () {
    expect($this->user)
        ->infolist()->toBeInstanceOf(UserInfolist::class)
        ->toList()->toBeInstanceOf(UserInfolist::class);
});
