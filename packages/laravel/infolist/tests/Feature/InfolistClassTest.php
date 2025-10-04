<?php

declare(strict_types=1);

use Workbench\App\Infolists\UserInfolist;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('has an infolist', function () {
    $infolist = $this->user->infolist();

    expect($infolist)
        ->toBeInstanceOf(UserInfolist::class)
        ->toArray()->toBeArray()
        ->toHaveCount(2)
        ->toEqualCanonicalizing([
            [
                'name' => 'name',
                'type' => 'text',
                'label' => 'Name',
                'value' => [
                    'v' => $this->user->name,
                    'f' => false,
                ],
            ],
            [
                'name' => 'created_at',
                'type' => 'datetime',
                'label' => 'Account made',
                'value' => [
                    'v' => $this->user->created_at->format('Y-m-d H:i:s'),
                    'f' => false,
                ],
            ],
        ]);
});

// it('throws an exception when no record is set', function () {
//     $infolist = UserInfolist::make();

//     $infolist->toArray();
// })->throws(RuntimeException::class);
