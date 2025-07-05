<?php

declare(strict_types=1);

use Honed\Stats\Attributes\UseOverview;
use Workbench\App\Models\User;
use Workbench\App\Overviews\UserOverview;

it('has attribute', function () {
    $attribute = new UseOverview(UserOverview::class);

    expect($attribute)
        ->toBeInstanceOf(UseOverview::class)
        ->overviewClass->toBe(UserOverview::class);

    expect(User::class)
        ->toHaveAttribute(UseOverview::class);
});
