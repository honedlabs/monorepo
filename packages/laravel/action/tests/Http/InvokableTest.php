<?php

declare(strict_types=1);

use Workbench\App\Models\User;
use Honed\Action\Tests\Stubs\Product;
use Honed\Action\Testing\InlineRequest;
use Workbench\App\ActionGroups\UserActions;

use function Pest\Laravel\post;

beforeEach(function () {
    $this->product = User::factory()->create();

    $this->actions = UserActions::make();

    $this->request = InlineRequest::fake()
        ->for($this->actions)
        ->record($this->product->id)
        ->name('update.name')
        ->fill();
});

it('executes the action', function () {
    $data = $this->request->getData();

    $response = post(route('actions.invoke', $this->actions), $data);

    $response->assertRedirect();

    $this->assertDatabaseHas('products', [
        'id' => $this->product->id,
        'name' => 'test',
    ]);
});

it('does not execute non-existent action', function () {
    $key = UserActions::encode(Product::class);

    $data = $this->request
        ->record($this->product->id)
        ->name('update.name')
        ->getData();

    $response = post(route('actions.invoke', $key), $data);

    $response->assertNotFound();
});

// it('does not execute for non-executable actions', function () {
//     $group = RouteUserActions::make();

//     $data = $this->request->for($group)->getData();

//     $response = post(route('actions.invoke', $group), $data);

//     $response->assertNotFound();
// });
