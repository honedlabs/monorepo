<?php

declare(strict_types=1);

namespace Honed\Honed\Responses\Concerns;

use Honed\Honed\Contracts\ViewsModel;
use Honed\Infolist\Infolist;

/**
 * @template TInfolist of \Honed\Infolist\Infolist = \Honed\Infolist\Infolist
 */
trait CanHaveInfolist
{
    public const INFOLIST_PROP = 'infolist';

    /**
     * The infolist to use for the view.
     *
     * @var bool|class-string<TInfolist>|TInfolist
     */
    protected $infolist = false;

    /**
     * Set the infolist.
     *
     * @param  class-string<TInfolist>|TInfolist|null  $value
     * @return $this
     */
    public function infolist(bool|string|Infolist $value = true): static
    {
        $this->infolist = $value;

        return $this;
    }

    /**
     * Get the infolist to use for the view.
     *
     * @return TInfolist|null
     */
    public function getInfolist(): ?Infolist
    {
        return match (true) {
            is_string($this->infolist) => ($this->infolist)::make(),
            $this->infolist instanceof Infolist => $this->infolist,
            $this->infolist === true && $this instanceof ViewsModel => $this->getModel()->infolist(), // @phpstan-ignore-line method.notFound
            default => null,
        };
    }

    /**
     * Convert the infolist to props.
     *
     * @return array<string, mixed>
     */
    protected function canHaveInfolistToProps(): array
    {
        if ($infolist = $this->getInfolist()) {
            return [
                self::INFOLIST_PROP => $infolist->toArray(),
            ];
        }

        return [];
    }
}
