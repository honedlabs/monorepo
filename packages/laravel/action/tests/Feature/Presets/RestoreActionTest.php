<?php

declare(strict_types=1);

use Workbench\App\Actions\Product\RestoreProduct;
use Workbench\App\Models\Product;

beforeEach(function () {
    $this->action = new RestoreProduct();
});

it('restores a single soft deleted model', function () {
    $product = Product::factory()->create();
    
    $product->delete();
    
    $this->assertSoftDeleted('products', [
        'id' => $product->id,
    ]);

    $restoredProduct = $this->action->handle($product);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'deleted_at' => null,
    ]);

    expect($restoredProduct)->toBeInstanceOf(Product::class);
    expect($restoredProduct->id)->toBe($product->id);
    expect($restoredProduct->deleted_at)->toBeNull();
});

it('restores multiple soft deleted models via query builder', function () {
    $products = Product::factory()->count(3)->create();
    
    // Soft delete all products
    $products->each->delete();
    
    // Verify they are soft deleted
    $products->each(function ($product) {
        $this->assertSoftDeleted('products', [
            'id' => $product->id,
        ]);
    });

    // Restore via query builder
    $query = Product::onlyTrashed()->whereIn('id', $products->pluck('id'));
    $restoredCount = $this->action->handle($query);

    // Verify all are restored
    $products->each(function ($product) {
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'deleted_at' => null,
        ]);
    });

    expect($restoredCount)->toBe(3);
});

it('restores models matching query conditions', function () {
    // Create products with different names
    $productA = Product::factory()->create(['name' => 'Product A']);
    $productB = Product::factory()->create(['name' => 'Product B']);
    $productC = Product::factory()->create(['name' => 'Product C']);
    
    // Soft delete all products
    collect([$productA, $productB, $productC])->each->delete();
    
    // Restore only products with name containing 'A'
    $query = Product::onlyTrashed()->where('name', 'like', '%A%');
    $restoredCount = $this->action->handle($query);

    // Verify only Product A is restored
    $this->assertDatabaseHas('products', [
        'id' => $productA->id,
        'deleted_at' => null,
    ]);

    $this->assertSoftDeleted('products', [
        'id' => $productB->id,
    ]);

    $this->assertSoftDeleted('products', [
        'id' => $productC->id,
    ]);

    expect($restoredCount)->toBe(1);
});

it('handles empty query builder results gracefully', function () {
    // Create a query that matches no soft deleted records
    $query = Product::onlyTrashed()->where('id', 999999);
    
    $result = $this->action->handle($query);

    expect($result)->toBe(0);
});

it('restores model that was already restored', function () {
    $product = Product::factory()->create();
    
    // Product is not deleted, so restore should work but not change anything
    $restoredProduct = $this->action->handle($product);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'deleted_at' => null,
    ]);

    expect($restoredProduct)->toBeInstanceOf(Product::class);
    expect($restoredProduct->id)->toBe($product->id);
});

it('calls after hook when restoring single model', function () {
    $product = Product::factory()->create();
    $product->delete();

    $action = new class extends RestoreProduct {
        public bool $afterCalled = false;
        public $afterModel = null;

        protected function after($models)
        {
            $this->afterCalled = true;
            $this->afterModel = $models;
        }
    };

    $restoredProduct = $action->handle($product);

    expect($action->afterCalled)->toBeTrue();
    expect($action->afterModel)->toBeInstanceOf(Product::class);
    expect($action->afterModel->id)->toBe($product->id);
});

it('calls after hook when restoring via query builder', function () {
    $products = Product::factory()->count(2)->create();
    $products->each->delete();

    $action = new class extends RestoreProduct {
        public bool $afterCalled = false;
        public $afterResult = null;

        protected function after($models)
        {
            $this->afterCalled = true;
            $this->afterResult = $models;
        }
    };

    $query = Product::onlyTrashed()->whereIn('id', $products->pluck('id'));
    $result = $action->handle($query);

    expect($action->afterCalled)->toBeTrue();
    expect($action->afterResult)->toBe(2);
});

it('handles restore within transaction', function () {
    $product = Product::factory()->create();
    $product->delete();

    // Mock a transaction failure scenario
    $action = new class extends RestoreProduct {
        protected function restore($model)
        {
            $models = parent::restore($model);
            
            // Simulate an error after restore but within transaction
            throw new \Exception('Transaction failure');
        }
    };

    expect(fn () => $action->handle($product))
        ->toThrow(\Exception::class, 'Transaction failure');

    // Verify the model is still soft deleted due to transaction rollback
    $this->assertSoftDeleted('products', [
        'id' => $product->id,
    ]);
});
