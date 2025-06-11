<?php

declare(strict_types=1);

use Honed\Refine\Attributes\UseRefiner;
use Workbench\App\Models\User;
use Workbench\App\Refiners\RefineUser;

it('has attribute', function () {
    $attribute = new UseRefiner(RefineUser::class);

    expect($attribute)
        ->toBeInstanceOf(UseRefiner::class)
        ->refinerClass->toBe(RefineUser::class);

    expect(User::class)
        ->toHaveAttribute(UseRefiner::class);
});
