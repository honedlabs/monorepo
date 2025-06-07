<?php

declare(strict_types=1);

use App\Binders\AdminBinder;
use App\Binders\AuthenticatableBinder;
use App\Binders\UserBinder;
use App\Models\User;
use Honed\Bind\RetrieveBinders;
use Illuminate\Support\Facades\App;

beforeEach(function () {
    $this->artisan('bind:clear');
});

it('gets binders if cached', function () {
    $this->artisan('bind:cache');

    expect(RetrieveBinders::get())
        ->{User::class}
        ->scoped(fn ($model) => $model
            ->toBeArray()
            ->toHaveCount(4)
            ->toHaveKeys([
                'admin',
                'default',
                'edit',
                'auth',
            ])
        );
});

it('gets binders if not cached', function () {
    expect(RetrieveBinders::get())
        ->toBeArray()
        ->toHaveCount(1)
        ->{User::class}
        ->scoped(fn ($model) => $model
            ->toBeArray()
            ->toHaveCount(4)
            ->toHaveKeys([
                'admin',
                'default',
                'edit',
                'auth',
            ])
        );
});

it('gets binders', function () {
    expect(RetrieveBinders::binders())
        ->toBeArray()
        ->toHaveCount(3)
        ->toEqualCanonicalizing([
            UserBinder::class,
            AdminBinder::class,
            AuthenticatableBinder::class,
        ]);
});

it('gets bindings from binder', function () {
    $binds = [];

    RetrieveBinders::bindings(UserBinder::class, $binds);

    expect($binds)
        ->toBeArray()
        ->toHaveCount(1)
        ->{User::class}
        ->scoped(fn ($model) => $model
            ->toBeArray()
            ->toHaveCount(2)
            ->toHaveKeys([
                'default',
                'edit',
            ])
        );
});

it('puts binders into cache', function () {
    $this->assertFileDoesNotExist(App::getCachedBindersPath());

    $binders = RetrieveBinders::get();

    RetrieveBinders::put($binders);

    $this->assertFileExists(App::getCachedBindersPath());
});
