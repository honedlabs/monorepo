<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use function Pest\Laravel\post;
use Honed\Action\Http\Requests\ActionRequest;
use Honed\Action\Testing\BulkActionRequest;

beforeEach(function () {
    BulkActionRequest::shouldFill();

    foreach (range(1, 10) as $i) {
        product();
    }
});

it('executes the action', function () {
    $data = BulkActionRequest::make()
        ->all()
        ->name('update.name')
        ->getData();

    $response = post(route('actions'), $data);
    
    $response->assertRedirect();
});

// it('is 404 for no name match', function () {
//     $data = BulkActionRequest::make()
//         ->fill()
//         ->record($this->product->getPublicId())
//         ->name('missing')
//         ->getData();

//     $response = post(route('actions'), $data);

//     $response->assertNotFound();
// }); 

// it('is 404 if no model is found', function () {
//     $data = BulkActionRequest::make()
//         ->fill()
//         ->record(Str::uuid()->toString())
//         ->name('update.name')
//         ->getData();

//     $response = post(route('actions'), $data);

//     $response->assertNotFound();
// });

// it('is 403 if the action is not allowed', function () {
//     $data = BulkActionRequest::make()
//         ->fill()
//         ->record($this->product->getPublicId())
//         ->name('update.description')
//         ->getData();

//     $response = post(route('actions'), $data);

//     $response->assertForbidden();
// });

// it('does not mix action types', function () {
//     $data = BulkActionRequest::make()
//         ->fill()
//         ->record($this->product->getPublicId())
//         ->name('create.product.name')
//         ->getData();

//     $response = post(route('actions'), $data);

//     $response->assertNotFound();
// });

// it('does not execute route actions', function () {
//     $data = BulkActionRequest::make()
//         ->fill()
//         ->record($this->product->getPublicId())
//         ->name('show')
//         ->getData();

//     $response = post(route('actions'), $data);

//     $response->assertRedirect(); // Returns back
// });

// it('returns inertia response', function () {
//     $data = BulkActionRequest::make()
//         ->fill()
//         ->record($this->product->getPublicId())
//         ->name('price.100')
//         ->getData();
    
//     $response = post(route('actions'), $data);

//     $response->assertInertia();

//     $this->assertDatabaseHas('products', [
//         'id' => $this->product->id,
//         'price' => 100,
//     ]);
// });
