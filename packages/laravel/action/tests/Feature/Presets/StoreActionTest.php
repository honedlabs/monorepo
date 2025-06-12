<?php

declare(strict_types=1);

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\ValidatedInput;
use Workbench\App\Actions\Product\StoreProduct;
use Workbench\App\Models\Product;

beforeEach(function () {
    $this->action = new StoreProduct();

    $this->assertDatabaseEmpty('products');
});

it('stores a model with validated input', function () {
    $input = new ValidatedInput([
        'name' => 'Test Product',
        'description' => 'Test Description',
        'price' => 99.99,
    ]);

    $product = $this->action->handle($input);

    expect($product)->toBeInstanceOf(Product::class);
    expect($product->name)->toBe('Test Product');
    expect($product->description)->toBe('Test Description');
    expect($product->price)->toBe(99.99);

    $this->assertDatabaseCount('products', 1);

    $this->assertDatabaseHas('products', [
        'name' => 'Test Product',
        'description' => 'Test Description',
        'price' => 99.99,
    ]);
});

it('stores a model with form request', function () {
    $formRequest = new class extends FormRequest {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            return [
                'name' => 'required|string',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
            ];
        }

        public function validated($key = null, $default = null)
        {
            return [
                'name' => 'Form Request Product',
                'description' => 'Form Request Description',
                'price' => 149.99,
            ];
        }

        public function safe(array $keys = null): ValidatedInput
        {
            return new ValidatedInput($this->validated());
        }
    };

    $product = $this->action->handle($formRequest);

    expect($product)->toBeInstanceOf(Product::class);
    expect($product->name)->toBe('Form Request Product');
    expect($product->description)->toBe('Form Request Description');
    expect($product->price)->toBe(149.99);

    $this->assertDatabaseCount('products', 1);

    $this->assertDatabaseHas('products', [
        'name' => 'Form Request Product',
        'description' => 'Form Request Description',
        'price' => 149.99,
    ]);
});

it('stores a model with minimal data', function () {
    $input = new ValidatedInput([
        'name' => 'Minimal Product',
    ]);

    $product = $this->action->handle($input);

    expect($product)->toBeInstanceOf(Product::class);
    expect($product->name)->toBe('Minimal Product');

    $this->assertDatabaseCount('products', 1);

    $this->assertDatabaseHas('products', [
        'name' => 'Minimal Product',
    ]);
});

it('calls prepare method correctly', function () {
    $action = new class extends StoreProduct {
        public $preparedData = null;

        protected function prepare($input): array
        {
            $prepared = parent::prepare($input);
            $this->preparedData = $prepared;
            $prepared['name'] = strtoupper($prepared['name']);
            return $prepared;
        }
    };

    $input = new ValidatedInput([
        'name' => 'lowercase product',
        'description' => 'Test Description',
    ]);

    $product = $action->handle($input);

    expect($action->preparedData)->toBe([
        'name' => 'lowercase product',
        'description' => 'Test Description',
    ]);

    expect($product->name)->toBe('LOWERCASE PRODUCT');
    expect($product->description)->toBe('Test Description');

    $this->assertDatabaseHas('products', [
        'name' => 'LOWERCASE PRODUCT',
        'description' => 'Test Description',
    ]);
});

it('calls after method correctly', function () {
    $action = new class extends StoreProduct {
        public $afterCalled = false;
        public $afterModel = null;
        public $afterInput = null;
        public $afterPrepared = null;

        protected function after($model, $input, $prepared)
        {
            $this->afterCalled = true;
            $this->afterModel = $model;
            $this->afterInput = $input;
            $this->afterPrepared = $prepared;
        }
    };

    $input = new ValidatedInput([
        'name' => 'After Test Product',
        'description' => 'After Test Description',
    ]);

    $product = $action->handle($input);

    expect($action->afterCalled)->toBeTrue();
    expect($action->afterModel)->toBe($product);
    expect($action->afterInput)->toBe($input);
    expect($action->afterPrepared)->toBe([
        'name' => 'After Test Product',
        'description' => 'After Test Description',
    ]);
});

it('handles empty validated input', function () {
    $input = new ValidatedInput([]);

    $product = $this->action->handle($input);

    expect($product)->toBeInstanceOf(Product::class);

    $this->assertDatabaseCount('products', 1);
});

it('returns the created model', function () {
    $input = new ValidatedInput([
        'name' => 'Return Test Product',
        'price' => 199.99,
    ]);

    $product = $this->action->handle($input);

    expect($product)->toBeInstanceOf(Product::class);
    expect($product->exists)->toBeTrue();
    expect($product->wasRecentlyCreated)->toBeTrue();
    expect($product->id)->toBeInt();
});

it('stores multiple products sequentially', function () {
    $firstInput = new ValidatedInput([
        'name' => 'First Product',
        'price' => 99.99,
    ]);

    $secondInput = new ValidatedInput([
        'name' => 'Second Product',
        'price' => 149.99,
    ]);

    $firstProduct = $this->action->handle($firstInput);
    $secondProduct = $this->action->handle($secondInput);

    expect($firstProduct->id)->not()->toBe($secondProduct->id);

    $this->assertDatabaseCount('products', 2);

    $this->assertDatabaseHas('products', [
        'name' => 'First Product',
        'price' => 99.99,
    ]);

    $this->assertDatabaseHas('products', [
        'name' => 'Second Product',
        'price' => 149.99,
    ]);
});
