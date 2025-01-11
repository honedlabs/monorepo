<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Concerns\IsDefault;
use Honed\Core\Contracts\HigherOrder;
use Honed\Core\Contracts\ProxiesHigherOrder;
use Honed\Core\Link\Concerns\Linkable;
use Honed\Core\Link\Proxies\HigherOrderLink;

/**
 * @property-read \Honed\Core\Link\Proxies\HigherOrderLink $link
 */
class PageAction extends Action implements ProxiesHigherOrder
{
    use Linkable;

    public function setUp(): void
    {
        $this->type(Creator::Page);
    }

    public function __get(string $property): HigherOrder
    {
        return match ($property) {
            'link' => new HigherOrderLink($this),
            default => parent::__get($property),
        };
    }

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'link' => $this->link()
        ]);
    }
}