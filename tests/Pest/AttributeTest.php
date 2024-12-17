<?php

use Honed\Crumb\Tests\Stubs\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\get;

it('dummy', function () {
    get(route('product.index'));
});