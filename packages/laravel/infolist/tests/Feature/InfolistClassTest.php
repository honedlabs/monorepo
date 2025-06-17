<?php

declare(strict_types=1);

use Honed\Infolist\Entries\Entry;
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
        ->toEqual([
            [
                'type' => Entry::TEXT,
                'label' => 'Name',
                'state' => $this->user->name,
                'placehold' => null,
                'badge' => null,
                'variant' => null,
                'class' => null,
            ],
            [
                'type' => Entry::DATETIME,
                'label' => 'Account made',
                'state' => $this->user->created_at->format('Y-m-d H:i:s'),
                'placehold' => null,
                'badge' => null,
                'variant' => null,
                'shape' => null,
                'class' => null,
            ],
        ]);
});
