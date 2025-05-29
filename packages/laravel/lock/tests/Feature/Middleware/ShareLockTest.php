<?php

declare(strict_types=1);

use Honed\Lock\Facades\Lock;
use Honed\Lock\Support\Parameters;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = user();

    $this->actingAs($this->user);
});

it('shares lock', function () {
    get('/')->assertInertia(fn (Assert $page) => $page
        ->has(Parameters::PROP, fn (Assert $lock) => $lock
            ->where('view', true)
            ->where('edit', false)
        )
        ->etc()
    );
});

it('shares lock with a product', function () {
    Lock::appendToModels();

    $product = product();

    get(route('product.show', $product))->assertInertia(fn (Assert $page) => $page
        ->has(Parameters::PROP, 2)
        ->has('product', fn (Assert $product) => $product
            ->has(Parameters::PROP, fn (Assert $lock) => $lock
                ->where('viewAny', true)
                ->where('view', false)
                ->where('create', true)
                ->where('update', true)
                ->where('delete', false)
                ->where('restore', true)
            )->etc()
        )->etc()
    );
});
