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
            ...($this->hasDestination() ? $this->getDestination()->toArray() : [])
        ]);
    }

    public function resolve($parameters = null, $typed = null): static
    {
        $this->getDestination($parameters, $typed);
        
        return parent::resolve($parameters, $typed);
    }
}