<?php

declare(strict_types=1);

namespace Honed\Crumb\Tests\Stubs;

use Illuminate\Http\Request;
use Honed\Crumb\Attributes\Crumb;
use Honed\Crumb\Concerns\Crumbs;
use Honed\Crumb\Tests\Stubs\Product;
use Illuminate\Support\Facades\Route;

#[Crumb('Basic')]
class ProductController
{
    use Crumbs;

    #[Crumb('Products')]
    public function index(Request $request)
    {

        return inertia('Product/Index');
    }

    #[Crumb('Products')]
    public function show(Request $request, Product $product)
    {
        return inertia('Product/Show', ['product' => $product]);
    }

    public function edit(Request $request, Product $product)
    {
        return inertia('Product/Edit', ['product' => $product]);
    }
}
