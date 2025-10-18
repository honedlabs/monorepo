<?php

declare(strict_types=1);

use App\Classes\GetLocale;
use App\Classes\GetProduct;
use App\Classes\GetUser;
use App\Enums\Locale;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();
})->only();

it('resolves interface', function (string $route) {
    get($route);

    $user = app()->make(GetUser::class)->get();

    expect($user)
        ->toBeInstanceOf(User::class)
        ->is($this->user)->toBeTrue();
})->with([
    fn () => route('users.show', $this->user),
    fn () => route('locales.users.show', [Locale::English, $this->user]),
    fn () => route('products.users.show', [Product::factory()->create(), $this->user]),
]);

it('resolves primitive', function () {
    get(route('locales.users.show', [Locale::English, $this->user]));

    $locale = app()->make(GetLocale::class)->get();

    expect($locale)
        ->toBe(Locale::English);
});

it('uses container binding if the parameter is not found', function () {
    get(route('users.show', $this->user));

    $product = app()->make(GetProduct::class)->get();

    expect($product)
        ->toBeInstanceOf(Product::class)
        ->exists->toBeFalse();
});