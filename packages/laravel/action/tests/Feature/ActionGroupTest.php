<?php

declare(strict_types=1);

use Honed\Action\PageAction;
use Honed\Action\ActionGroup;
use Workbench\App\Models\User;
use Honed\Action\Tests\Stubs\Product;
use Illuminate\Http\RedirectResponse;
use Honed\Action\Testing\RequestFactory;
use Honed\Action\Tests\Stubs\ProductActions;

beforeEach(function () {
    $this->group = ActionGroup::make(PageAction::make('create'));
});

it('has model', function () {
    expect($this->group)
        ->getModel()->toBeNull()
        ->for(User::factory()->create())->toBe($this->group)
        ->getModel()->toBeInstanceOf(User::class);
});

it('has route key name', function () {
    expect($this->group)
        ->getRouteKeyName()->toBe('action');
});

it('requires builder to handle requests', function () {
    $request = RequestFactory::page()
        ->fill()
        ->validate();

    expect($this->group->handle($request))
        ->toBeInstanceOf(RedirectResponse::class);
})->throws(\RuntimeException::class);

it('handles requests with model', function () {

    $request = RequestFactory::page()
        ->fill()
        ->name('create.user.name')
        ->validate();

    expect(Product::query()->count())->toBe(0);

    expect(ProductActions::make())
        ->handle($request)
        ->toBeInstanceOf(RedirectResponse::class);

    expect(Product::query()->count())->toBe(1);
});

it('resolves route binding', function () {
    expect($this->group)
        ->resolveRouteBinding($this->group->getRouteKey())
        ->toBeNull();

    $actions = ProductActions::make();

    expect($actions)
        ->resolveRouteBinding($actions->getRouteKey())
        ->toBeInstanceOf(ProductActions::class);

    expect($actions)
        ->resolveChildRouteBinding(ProductActions::class, $actions->getRouteKey())
        ->toBeInstanceOf(ProductActions::class);
});

it('resolves action group', function () {
    ActionGroup::useNamespace('');

    ProductActions::guessActionGroupNamesUsing(function ($class) {
        return $class.'Actions';
    });

    expect(ProductActions::resolveActionGroupName(Product::class))
        ->toBe('Honed\\Action\\Tests\\Stubs\\ProductActions');

    expect(ProductActions::actionGroupForModel(Product::class))
        ->toBeInstanceOf(ProductActions::class);

    ProductActions::flushState();
});

it('uses namespace', function () {
    ActionGroup::useNamespace('');

    expect(ProductActions::resolveActionGroupName(Product::class))
        ->toBe('Honed\\Action\\Tests\\Stubs\\ProductActions');

    ProductActions::flushState();
});

it('has array representation', function () {
    expect($this->group->toArray())
        ->toBeArray()
        ->toHaveCount(3)
        ->toHaveKeys(['inline', 'bulk', 'page']);
});

it('has array representation with server actions', function () {
    expect(ProductActions::make()->for(User::factory()->create())->toArray())
        ->toBeArray()
        ->toHaveCount(5)
        ->toHaveKeys(['id', 'endpoint', 'inline', 'bulk', 'page']);

    expect(ProductActions::make()->for(User::factory()->create())->executes(false)->toArray())
        ->toHaveCount(3)
        ->toHaveKeys(['inline', 'bulk', 'page']);
});

it('has array representation with model', function () {
    $user = User::factory()->create();

    expect(ProductActions::make()->for($user)->toArray())
        ->toBeArray()
        ->toHaveCount(5)
        ->toHaveKeys(['inline', 'bulk', 'page', 'id', 'endpoint']);
});
