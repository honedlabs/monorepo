<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Concerns\HasDestination;
use Illuminate\Support\Traits\ForwardsCalls;

class PageAction extends Action
{
    use HasDestination;
    use ForwardsCalls;

    protected $type = Creator::Page;

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'to' => $this->resolveDestination()
        ]);
    }
}