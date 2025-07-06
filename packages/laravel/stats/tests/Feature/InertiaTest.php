<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();

    Product::factory(10)
        ->for($this->user)
        ->create();
})->only();

it('renders page', function () {
    dd(get(route('users.show', $this->user)));
    get(route('users.show', $this->user))
        ->assertInertia(fn (Assert $assert) => $assert
            ->dd()
        );
});