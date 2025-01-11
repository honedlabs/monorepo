<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Contracts\HigherOrder;
use Honed\Core\Contracts\ProxiesHigherOrder;

class BulkAction extends Action implements ProxiesHigherOrder
{
    use Concerns\MorphsAction;
    use Concerns\HasAction;

    public function setUp(): void
    {
        $this->type(Creator::Bulk);
    }

    public function __get(string $property): HigherOrder
    {
        return match ($property) {
            // 'confirm' => new HigherOrderConfirm($this),
            default => parent::__get($property),
        };
    }

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'action' => $this->hasAction(),
            // 'confirm' => $this->confirm(),
            // 'deselect' => $this->deselect(),
        ]);
    }

    /**
     * Morph this action to accomodate for inline requests.
     * 
     * @return $this
     */
    public function isAlsoInline(): static
    {
        return $this->morph();
    }

    public function handle()
    {
        //
    }
}