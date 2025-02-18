<?php

declare(strict_types=1);

namespace Tests\Pest\Fixtures;

use Honed\Action\Tests\Stubs\Product;
use Honed\Action\Contracts\Actionable;

class DestroyProduct implements Actionable
{
    public function handle(Product $product)
    {
        $product->delete();

        return back();
    }
}
