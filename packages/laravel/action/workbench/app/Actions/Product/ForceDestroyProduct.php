<?php

declare(strict_types=1);

namespace Workbench\App\Actions\Product;

use Workbench\App\Models\Product;
use Honed\Action\Actions\ForceDestroyAction;

/**
 * @template TModel of \Workbench\App\Models\Product
 *
 * @extends \Honed\Action\Actions\ForceDestroyAction<TModel>
 */
class ForceDestroyProduct extends ForceDestroyAction
{
    /**
     * {@inheritdoc}
     */
    public function from(): string
    {
        return Product::class;
    }
}
