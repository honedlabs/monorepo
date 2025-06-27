<?php

declare(strict_types=1);

namespace Honed\Honed\Concerns;

use Honed\Table\Concerns\HasTable;
use Honed\Action\Concerns\HasBatch;

/**
 * @template TTable of \Honed\Table\Table = \Honed\Table\Table
 * @template TActions of \Honed\Action\Batch = \Honed\Action\Batch
 */
trait IsHoned
{
    /** @use HasTable<TTable> */
    use HasTable;

    /** @use HasBatch<TActions> */
    use HasBatch;
}