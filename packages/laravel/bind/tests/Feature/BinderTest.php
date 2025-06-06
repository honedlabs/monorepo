<?php

declare(strict_types=1);

use App\Binders\AdminBinder;
use App\Binders\UserBinder;
use App\Models\User;
use Honed\Bind\Binder;

beforeEach(function () {
    $this->artisan('bind:cache');

    Binder::flushState();
});

it('uses cache', function () {
    expect(Binder::for(User::class, 'edit'))
        ->toBeInstanceOf(UserBinder::class);
});

it('recaches', function () {
    $this->artisan('bind:clear');

    expect(Binder::for(User::class, 'edit'))
        ->toBeInstanceOf(UserBinder::class);
})->skip();

it('gets class name from attribute', function () {
    expect(UserBinder::getBindsAttribute())
        ->toBeNull();

    expect(AdminBinder::getBindsAttribute())
        ->toBe(User::class);
});

it('guesses model name', function () {

})->skip();

it('uses custom namespace', function () {
    Binder::useNamespace('App\\Binders\\');

    expect(Binder::for(User::class, 'edit'))
        ->toBeInstanceOf(UserBinder::class);
});

it('resolves binding', function () {

});

it('resolves binding query', function () {

});

it('gets model name from property', function () {

});

it('gets model name from resolver', function () {
    
});
