<?php

use App\Binders\UserBinder;
use App\Models\User;
use Honed\Bind\Binder;

beforeEach(function () {
    $this->artisan('bind:cache');
});

it('uses cache', function () {
    expect(Binder::for(User::class, 'edit'))
        ->toBeInstanceOf(UserBinder::class);
});

// it('uses model', function () {
//     expect(Binder::for(User::class, 'edit'))
// })