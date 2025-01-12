<?php

declare(strict_types=1);

namespace Honed\Action\Tests\Stubs;

use Honed\Action\Contracts\HandlesAction;
use Honed\Action\InlineAction;

class DestroyAction extends InlineAction implements HandlesAction
{
    public function setUp(): void
    {
        $this->name('destroy');
        $this->label(fn (Product $product) => 'Destroy '.$product->name);
    }

    public function handle($product)
    {
        $product->delete();
    }
}
