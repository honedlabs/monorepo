<?php

declare(strict_types=1);

namespace Honed\Lock\Tests\Stubs;

class ProductController extends Controller
{
    public function index()
    {
        return inertia('Product/Index', [
            'products' => Product::all(),
        ]);
    }

    public function show(Product $product)
    {
        return inertia('Product/Show', [
            'product' => $product,
        ]);
    }
}
