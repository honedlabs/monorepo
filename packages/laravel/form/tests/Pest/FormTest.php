<?php

declare(strict_types=1);

use Honed\Form\Form;
use Honed\Form\Tests\Fixtures\BasicRequest;
use Illuminate\Support\Arr;

it('tests', function () {
    dd(
        Form::make()
            ->defaults('name'),

        Arr::accessible(product())
    );

    
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
    
