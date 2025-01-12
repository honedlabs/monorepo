<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Concerns\HasDestination;
use Illuminate\Support\Traits\ForwardsCalls;

class PageAction extends Action
{
    use ForwardsCalls;
    use HasDestination;

    protected $type = Creator::Page;

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            ...($this->hasDestination() ? $this->getDestination()->toArray() : []), // @phpstan-ignore-line
        ]);
    }

    public function resolve($parameters = null, $typed = null): static
    {
        // $this->resolveDestination($parameters, $typed);

        return parent::resolve($parameters, $typed);
    }
}
