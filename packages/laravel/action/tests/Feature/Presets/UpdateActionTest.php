<?php

declare(strict_types=1);

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Workbench\App\Actions\Product\UpdateProduct;
use Workbench\App\Models\Product;

beforeEach(function () {
    $this->action = new UpdateProduct();

    $this->product = Product::factory()->create([
        'name' => 'Original Name',
        'description' => 'Original Description',
        'price' => 100,
    ]);
});

it('updates a model with ValidatedInput', function () {
    $validator = Validator::make([
        'name' => 'Updated Name',
        'description' => 'Updated Description',
    ], []);

    $input = $validator->safe();

    $result = $this->action->handle($this->product, $input);

    expect($result)->toBe($this->product);

    $this->product->refresh();

    expect($this->product->name)->toBe('Updated Name');
    expect($this->product->description)->toBe('Updated Description');
    expect($this->product->price)->toBe(100); // Should remain unchanged
});

it('updates a model with ValidatedInput containing all attributes', function () {
    $validator = Validator::make([
        'name' => 'New Name',
        'description' => 'New Description',
        'price' => 250,
    ], []);

    $input = $validator->safe();

    $result = $this->action->handle($this->product, $input);

    expect($result)->toBe($this->product);

    $this->product->refresh();

    expect($this->product->name)->toBe('New Name');
    expect($this->product->description)->toBe('New Description');
    expect($this->product->price)->toBe(250);
});

it('updates a model with ValidatedInput containing partial attributes', function () {
    $validator = Validator::make([
        'price' => 500,
    ], []);

    $input = $validator->safe();

    $result = $this->action->handle($this->product, $input);

    expect($result)->toBe($this->product);

    $this->product->refresh();

    expect($this->product->name)->toBe('Original Name'); // Should remain unchanged
    expect($this->product->description)->toBe('Original Description'); // Should remain unchanged
    expect($this->product->price)->toBe(500);
});

it('updates a model with empty ValidatedInput', function () {
    $validator = Validator::make([], []);

    $input = $validator->safe();

    $result = $this->action->handle($this->product, $input);

    expect($result)->toBe($this->product);

    $this->product->refresh();

    // All attributes should remain unchanged
    expect($this->product->name)->toBe('Original Name');
    expect($this->product->description)->toBe('Original Description');
    expect($this->product->price)->toBe(100);
});

it('updates a model with FormRequest', function () {
    $request = new class extends FormRequest {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            return [];
        }

        protected function prepareForValidation(): void
        {
            $this->merge([
                'name' => 'FormRequest Name',
                'description' => 'FormRequest Description',
            ]);
        }
    };

    $request->setContainer(app());
    $request->setValidator(Validator::make([], []));
    $request->prepareForValidation();

    $result = $this->action->handle($this->product, $request);

    expect($result)->toBe($this->product);

    $this->product->refresh();

    expect($this->product->name)->toBe('FormRequest Name');
    expect($this->product->description)->toBe('FormRequest Description');
    expect($this->product->price)->toBe(100); // Should remain unchanged
});

it('updates a model with FormRequest containing all attributes', function () {
    $request = new class extends FormRequest {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            return [];
        }

        protected function prepareForValidation(): void
        {
            $this->merge([
                'name' => 'Complete FormRequest Name',
                'description' => 'Complete FormRequest Description',
                'price' => 750,
            ]);
        }
    };

    $request->setContainer(app());
    $request->setValidator(Validator::make([], []));
    $request->prepareForValidation();

    $result = $this->action->handle($this->product, $request);

    expect($result)->toBe($this->product);

    $this->product->refresh();

    expect($this->product->name)->toBe('Complete FormRequest Name');
    expect($this->product->description)->toBe('Complete FormRequest Description');
    expect($this->product->price)->toBe(750);
});

it('updates a model with FormRequest containing partial attributes', function () {
    $request = new class extends FormRequest {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            return [];
        }

        protected function prepareForValidation(): void
        {
            $this->merge([
                'name' => 'Partial FormRequest Name',
            ]);
        }
    };

    $request->setContainer(app());
    $request->setValidator(Validator::make([], []));
    $request->prepareForValidation();

    $result = $this->action->handle($this->product, $request);

    expect($result)->toBe($this->product);

    $this->product->refresh();

    expect($this->product->name)->toBe('Partial FormRequest Name');
    expect($this->product->description)->toBe('Original Description'); // Should remain unchanged
    expect($this->product->price)->toBe(100); // Should remain unchanged
});

it('updates a model with empty FormRequest', function () {
    $request = new class extends FormRequest {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            return [];
        }
    };

    $request->setContainer(app());
    $request->setValidator(Validator::make([], []));

    $result = $this->action->handle($this->product, $request);

    expect($result)->toBe($this->product);

    $this->product->refresh();

    // All attributes should remain unchanged
    expect($this->product->name)->toBe('Original Name');
    expect($this->product->description)->toBe('Original Description');
    expect($this->product->price)->toBe(100);
});
