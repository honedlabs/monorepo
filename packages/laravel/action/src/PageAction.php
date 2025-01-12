<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Concerns\HasDestination;

class PageAction extends Action
{
    use HasDestination;

    public function setUp(): void
    {
        $this->type(Creator::Page);
    }

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'to' => $this->resolveDestination()
        ]);
    }
}