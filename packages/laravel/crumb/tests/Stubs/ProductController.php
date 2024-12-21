<?php

declare(strict_types=1);

namespace Honed\Crumb\Tests\Stubs;

use Honed\Crumb\Attributes\Crumb;
use Honed\Crumb\Concerns\HasCrumbs;
use Illuminate\Http\Request;

#[Crumb('products')]
class ProductController extends Controller
{
    use HasCrumbs;

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
