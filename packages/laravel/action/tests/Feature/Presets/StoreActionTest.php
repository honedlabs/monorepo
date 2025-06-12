<?php

declare(strict_types=1);

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\ValidatedInput;
use Workbench\App\Actions\Product\StoreProduct;
use Workbench\App\Models\Product;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->action = new StoreProduct();

    $this->assertDatabaseEmpty('products');
});

it('stores a model with validated input', function () {
    $user = User::factory()->create();
    
    $input = new ValidatedInput([
        'name' => 'Test Product',
        'description' => 'Test description',
        'price' => 999,
        'user_id' => $user->id,
        'best_seller' => true,
    ]);

    $product = $this->action->handle($input);

    $this->assertDatabaseCount('products', 1);
    $this->assertInstanceOf(Product::class, $product);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Test Product',
        'description' => 'Test description',
        'price' => 999,
        'user_id' => $user->id,
        'best_seller' => true,
    ]);
});

it('stores a model with form request', function () {
    $user = User::factory()->create();
    
    $formRequest = new class($user->id) extends FormRequest {
        public function __construct(private int $userId)
        {
            parent::__construct();
        }
        
        public function rules(): array
        {
            return [];
        }
        
        public function safe($keys = null)
        {
            return new ValidatedInput([
                'name' => 'Form Request Product',
                'description' => 'Form request description', 
                'price' => 555,
                'user_id' => $this->userId,
                'best_seller' => false,
            ]);
        }
    };

    $product = $this->action->handle($formRequest);

    $this->assertDatabaseCount('products', 1);
    $this->assertInstanceOf(Product::class, $product);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Form Request Product',
        'description' => 'Form request description',
        'price' => 555,
        'user_id' => $user->id,
        'best_seller' => false,
    ]);
});

it('stores a model with minimal data', function () {
    $user = User::factory()->create();
    
    $input = new ValidatedInput([
        'name' => 'Minimal Product',
        'user_id' => $user->id,
    ]);

    $product = $this->action->handle($input);

    $this->assertDatabaseCount('products', 1);
    $this->assertInstanceOf(Product::class, $product);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Minimal Product',
        'user_id' => $user->id,
    ]);
});

it('stores multiple models', function () {
    $user = User::factory()->create();
    
    $products = [];
    
    for ($i = 1; $i <= 3; $i++) {
        $input = new ValidatedInput([
            'name' => "Product {$i}",
            'description' => "Description {$i}",
            'price' => $i * 100,
            'user_id' => $user->id,
        ]);

        $products[] = $this->action->handle($input);
    }

    $this->assertDatabaseCount('products', 3);

    foreach ($products as $index => $product) {
        $i = $index + 1;
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => "Product {$i}",
            'description' => "Description {$i}",
            'price' => $i * 100,
            'user_id' => $user->id,
        ]);
    }
});

it('stores a model with all fillable attributes', function () {
    $user = User::factory()->create();
    
    $input = new ValidatedInput([
        'public_id' => 'custom-public-id',
        'user_id' => $user->id,
        'name' => 'Full Product',
        'description' => 'Complete description',
        'price' => 1234,
        'best_seller' => true,
        'status' => 'active',
    ]);

    $product = $this->action->handle($input);

    $this->assertDatabaseCount('products', 1);
    $this->assertInstanceOf(Product::class, $product);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'public_id' => 'custom-public-id',
        'user_id' => $user->id,
        'name' => 'Full Product',
        'description' => 'Complete description',
        'price' => 1234,
        'best_seller' => true,
        'status' => 'active',
    ]);
});

it('returns the created model instance', function () {
    $user = User::factory()->create();
    
    $input = new ValidatedInput([
        'name' => 'Return Test Product',
        'user_id' => $user->id,
    ]);

    $product = $this->action->handle($input);

    expect($product)->toBeInstanceOf(Product::class);
    expect($product->name)->toBe('Return Test Product');
    expect($product->user_id)->toBe($user->id);
    expect($product->exists)->toBeTrue();
    expect($product->wasRecentlyCreated)->toBeTrue();
});

it('handles empty validated input', function () {
    $input = new ValidatedInput([]);

    $product = $this->action->handle($input);

    $this->assertDatabaseCount('products', 1);
    $this->assertInstanceOf(Product::class, $product);
    expect($product->exists)->toBeTrue();
});
