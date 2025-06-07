<?php

declare(strict_types=1);

use App\Binders\AdminBinder;
use App\Models\User;
use Honed\Bind\Attributes\Binds;

it('has attribute', function () {
    $attribute = new Binds(User::class);
    expect($attribute)
        ->toBeInstanceOf(Binds::class)
        ->model->toBe(User::class);

    expect(AdminBinder::class)
        ->toHaveAttribute(Binds::class);
});
