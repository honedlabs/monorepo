<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\User;
use Honed\Data\Rules\Authorized;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('fails if not authenticated', function () {
    $product = Product::factory()->for($this->user)->create();
    
    expect(new Authorized('view', Product::class, 'id'))
        ->isValid($product->getKey())->toBeFalse();
});

describe('authenticated', function () {
    beforeEach(function () {
        $this->actingAs($this->user);
    });

    it('passes policy for class string', function () {
        expect(new Authorized('create', Product::class))
            ->isValid(1)->toBeTrue();
    });

    it('fails policy for class string', function () {
        expect(new Authorized('viewAny', Product::class))
            ->isValid(1)->toBeFalse();
    });

    it('fails policy for class string if expecting column', function () {
        expect(new Authorized('create', Product::class, 'id'))
            ->isValid(1)->toBeFalse();
    });

    it('passes policy for class string if not expecting column', function () {
        expect(new Authorized('create', Product::class))
            ->isValid(1)->toBeTrue();
    });

    it('passes policy for model', function () {
        $product = Product::factory()->for($this->user)->create();
    
        expect(new Authorized('view', Product::class, 'id'))
            ->isValid($product->getKey())->toBeTrue();
    });
    
    it('fails policy for model', function () {
        $product = Product::factory()->create();
    
        expect(new Authorized('view', Product::class, 'id'))
            ->isValid($product->getKey())->toBeFalse();
    });


    it('passes validator', function () {
        $product = Product::factory()->for($this->user)->create();

        $validator = Validator::make([
            'value' => 1,
        ], [
            'value' => [new Authorized('view', Product::class, 'id')],
        ]);
    
        expect($validator->fails())->toBeFalse();
    });
    
    it('fails validator', function () {
        $product = Product::factory()->create();
                
        $validator = Validator::make([
            'value' => $product->getKey(),
        ], [
            'value' => [new Authorized('view', Product::class, 'id')],
        ]);
    
        expect($validator)
            ->fails()->toBeTrue()
            ->errors()
            ->scoped(fn ($bag) => $bag
                ->first('value')
                ->toBe('validation::validation.authorized')
            );
    });
    
});
