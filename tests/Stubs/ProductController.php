<?php

declare(strict_types=1);

namespace Honed\Crumb\Tests\Stubs;

use Honed\Crumb\Attributes\Crumb;
use Honed\Crumb\Concerns\Crumbs;
use Illuminate\Http\Request;

#[Crumb('products')]
class ProductController
{
    use Crumbs;

    public function index(Request $request)
    {
        return inertia('Product/Index');
    }

    #[Crumb('products')]
    public function show(Request $request, Product $product)
    {
        return inertia('Product/Show', ['product' => $product]);
    }

    public function edit(Request $request, Product $product)
    {
        return inertia('Product/Edit', ['product' => $product]);
    }
}
