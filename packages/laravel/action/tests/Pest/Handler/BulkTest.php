<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use function Pest\Laravel\post;
use Honed\Action\Http\Requests\ActionRequest;
use Honed\Action\Testing\BulkActionRequest;
use Honed\Action\Tests\Stubs\Product;

beforeEach(function () {
    BulkActionRequest::shouldFill();

    foreach (range(1, 10) as $i) {
        product();
    }
});

it('executes the action', function () {
    $data = BulkActionRequest::make()
        ->all()
        ->name('update.description')
        ->getData();

    $response = post(route('actions'), $data);
    
    $response->assertRedirect();

    expect(Product::all())
        ->each(fn ($product) => $product
            ->description->toBe('test')
        );
});

it('is 404 for no name match', function () {
    $data = BulkActionRequest::make()
        ->all()
        ->name('missing')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertNotFound();
}); 


it('is 403 if the action is not allowed', function () {
    $data = BulkActionRequest::make()
        ->all()
        ->name('update.name')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertForbidden();
});

it('does not mix action types', function () {
    $data = BulkActionRequest::make()
        ->all()
        ->name('create.product.name')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertNotFound();
});

it('returns inertia response', function () {
    $data = BulkActionRequest::make()
        ->all()
        ->name('price.50')
        ->getData();
    
    $response = post(route('actions'), $data);

    $response->assertInertia();

    expect(Product::all())
        ->each(fn ($product) => $product
            ->price->toBe(50)
        );
});

it('applies only to selected records', function () {
    $ids = [1, 2, 3, 4, 5];
    $data = BulkActionRequest::make()
        ->only($ids)
        ->name('update.description')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertRedirect();

    expect(Product::query()->whereIn('id', $ids)->get())
        ->each(fn ($product) => $product
            ->description->toBe('test')
        );

    expect(Product::query()->whereNotIn('id', $ids)->get())
        ->each(fn ($product) => $product
            ->description->not->toBe('test')
        );
    

});

it('applies all excepted records', function () {
    $ids = [1, 2];

    $data = BulkActionRequest::make()
        ->all()
        ->except($ids)
        ->name('update.description')
        ->getData();

    $response = post(route('actions'), $data);

    $response->assertRedirect();

    expect(Product::query()->whereIn('id', $ids)->get())
        ->each(fn ($product) => $product
            ->description->not->toBe('test')
        );

    expect(Product::query()->whereNotIn('id', $ids)->get())
        ->each(fn ($product) => $product
            ->description->toBe('test')
        );
});
