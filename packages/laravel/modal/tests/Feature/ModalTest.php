<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\User;
use Honed\Modal\Support\ModalHeader;
use Inertia\Support\Header;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\from;
use function Pest\Laravel\get;

beforeEach(function () {});

it('can be rendered', function () {
    $user = User::factory()->create();
    $product = Product::factory()->for($user)->create();

    get(route('users.products.show', [$user, $product]))
        ->assertSuccessful()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Users/Show')
            ->has('modal', fn (AssertableInertia $page) => $page
                ->where('baseURL', route('users.show', $user))
                ->where('component', 'Products/Show')
                ->has('props', fn (AssertableInertia $page) => $page
                    ->has('product', fn (AssertableInertia $page) => $page
                        ->where('id', $product->id)
                        ->etc()
                    )
                    ->has('user', fn (AssertableInertia $page) => $page
                        ->where('id', $user->id)
                        ->etc()
                    )
                )
                ->etc()
            )
        );
});

it('passes raw data without model bindings', function () {
    $user = 'test-user';
    $product = 'test-product';

    get(route('raw.users.products.show', [$user, $product]))
        ->assertSuccessful()
        ->assertInertia(function (AssertableInertia $page) use ($user, $product) {
            $page->component('Users/Show')
                ->where('modal.baseURL', route('raw.users.show', $user))
                ->where('modal.component', 'Products/Show')
                ->where('modal.props.user', $user)
                ->where('modal.props.product', $product);
        });
});

it('preserves background on inertia visits', function () {
    $from = route('home');
    $user = User::factory()->create();
    $product = Product::factory()->for($user)->create();

    from($from)
        ->get(route('users.products.show', [$user, $product]), [
            Header::INERTIA => true,
            ModalHeader::REDIRECT => $from,
        ])
        ->assertSuccessful()
        ->assertJsonPath('component', 'Home')
        ->assertJsonPath('props.modal.redirectURL', $from)
        ->assertJsonPath('props.modal.baseURL', route('users.show', $user));
});

it('preserves background on non-inertia visits', function () {
    $from = route('home');
    $user = User::factory()->create();
    $product = Product::factory()->for($user)->create();

    from($from)
        ->get(route('users.products.show', [$user, $product]))
        ->assertSuccessful()
        ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Users/Show')
                ->has('user', fn (AssertableInertia $page) => $page
                    ->where('id', $user->id)
                    ->etc()
                )
                ->has('modal', fn (AssertableInertia $page) => $page
                    ->where('redirectURL', route('users.show', $user))
                    ->where('baseURL', route('users.show', $user))
                    ->etc()
                )
            );
});

it('preserves query string for parent component', function () {
    $user = User::factory()->create();
    $product = Product::factory()->for($user)->create();

    $from = route('users.show', ['user' => $user, 'page' => 3]);

    from($from)
        ->get(route('users.products.show', [$user, $product]), [
            Header::INERTIA => true,
            ModalHeader::REDIRECT => $from,
        ])
        ->assertJsonPath('component', 'Users/Show')
        ->assertJsonPath('props.page', '3')
        ->assertJsonPath('props.modal.redirectURL', $from);
});

it('binds route parameters correctly', function () {
    $from = route('home');
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $product = Product::factory()->for($user)->create();

    from($from)
        ->get(route('different.users.products.show', [$user, $product]))
        ->assertSuccessful()
        ->assertInertia(function (AssertableInertia $page) use ($otherUser) {
            $page->component('Users/Show')
                ->where('user.id', $otherUser->id)
                ->where('modal.redirectURL', route('users.show', $otherUser))
                ->where('modal.baseURL', route('users.show', $otherUser));
        });
});
