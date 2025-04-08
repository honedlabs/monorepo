<?php

declare(strict_types=1);

use Honed\Form\Form;
use Honed\Form\Tests\Fixtures\BasicRequest;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->form = Form::make();
});

it('has rules', function () {
    $arr = [
        'name' => 'required|string|min:1|max:255',
    ];

    $request = new BasicRequest();

    expect($this->form)
        // Empty by default
        ->getRules()->toEqual([])
        // Accepts arrays
        ->from($arr)->toBe($this->form)
        ->getRules()->toEqual($arr)
        // Accepts FormRequest instances
        ->from($request)->toBe($this->form)
        ->getRules()->toEqual($request->rules())
        // Accepts class-strings
        ->from(BasicRequest::class)->toBe($this->form)
        ->getRules()->toEqual($request->rules());
});

it('has default', function () {
    expect($this->form)
        ->getDefaults()->toBe([])
        ->defaults('name', 'Product Name')->toBe($this->form)
        ->getDefaults()->toEqual(['name' => 'Product Name']);
});

it('has defaults', function () {
    expect($this->form)
        ->defaults(['name' => 'Product Name'])->toBe($this->form)
        ->getDefaults()->toEqual(['name' => 'Product Name']);
});

it('has alias', function () {
    expect($this->form)
        ->getAliases()->toBe([])
        ->alias('name', 'product_name')->toBe($this->form)
        ->getAliases()->toEqual(['name' => 'product_name']);
});

it('has aliases', function () {
    expect($this->form)
        ->alias(['name' => 'product_name'])->toBe($this->form)
        ->getAliases()->toEqual(['name' => 'product_name']);
});

it('has append', function () {
    expect($this->form)
        ->getAppends()->toBe([])
        ->append('name', 'Product Name')->toBe($this->form)
        ->getAppends()->toEqual(['name' => 'Product Name']);
});

it('has appends', function () {
    expect($this->form)
        ->getAppends()->toBe([])
        ->appends(['name' => 'Product Name'])->toBe($this->form)
        ->getAppends()->toEqual(['name' => 'Product Name']);
});

// return Form::make()

//     ->safe()
//     ->validated()
//     ->except()

//     ->from(BasicRequest::class) // Checks if instanceof FormRequest
//     ->from(request()->rules()) // must be array of rules ['', ''] or 'key|test'

//     ->defaults('name', 'Product Name')
//     ->defaults(['name' => 'Product Name' ])

//     ->store(Product::class) // Store the form directly
//     ->update(product()) // Update the form with the product
//     ->destroy(product()) // Destroy the form with the product

//     /**
//      * Set the timezone for storing the dates, and then for retrieving them out.
//      */
//     ->timezone()

//     ->alias('key', 'actualKey')
//     ->alias([
//         'key' => 'actualKey',
//     ])

//     /**
//      * Append a key value pair to the form.
//      */
//     ->append('key', 'value')
//     ->append([
//         'key' => 'value',
//     ])

//     ->auto() // Whether to supply the form structure alongside the data when serializing to JSON

// // Converts to typescript definitions via a writer
    
