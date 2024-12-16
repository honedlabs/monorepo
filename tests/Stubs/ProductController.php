<?php

declare(strict_types=1);

namespace Honed\Crumb\Tests\Stubs;

use Honed\Crumb\Tests\Stubs\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController
{
    public function index(Request $request,)
    {
        return inertia('Product/Index');
    }

    public function show(Request $request, Product $product)
    {
        return inertia('Product/Show', ['product' => $product]);
    }

    public function edit(Request $request, Product $product)
    {
        return inertia('Product/Edit', ['product' => $product]);
    }
}
