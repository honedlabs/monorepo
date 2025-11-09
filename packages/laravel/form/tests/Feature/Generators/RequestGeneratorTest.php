<?php

declare(strict_types=1);

use App\Http\Requests\ProductRequest;
use Honed\Form\Generators\RequestGenerator;

beforeEach(function () {
    $this->generator = app(RequestGenerator::class);
});

it('tests', function () {
    $this->generator->for(ProductRequest::class)->generate();
})->only();
