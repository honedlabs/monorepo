<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Concerns\IsDefault;
use Honed\Core\Contracts\HigherOrder;
use Honed\Action\Concerns\MorphsAction;
use Honed\Core\Contracts\ProxiesHigherOrder;
use Honed\Core\Link\Proxies\HigherOrderLink;

class InlineAction extends Action implements ProxiesHigherOrder
{
    // use Confirmable;
    use IsDefault;
    use MorphsAction;

    public function setUp(): void
    {
        $this->type(Creator::Inline);
    }

    public function __get(string $property): HigherOrder
    {
        return match ($property) {
            // 'confirm' => new HigherOrderConfirm($this),
            'link' => new HigherOrderLink($this),
            default => parent::__get($property),
        };
    }

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'action' => $this->hasAction(),
            // 'confirm' => $this->confirm(),
            'link' => $this->link(),
        ]);
    }

    /**
     * Morph this action to accomodate for bulk requests.
     */
    public function bulk()
    {
        return $this->morph();
    }
}