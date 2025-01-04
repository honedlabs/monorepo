<?php

declare(strict_types=1);

namespace Honed\Core\Link\Concerns;

use Honed\Core\Link\Link;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait Linkable
{
    /**
     * @var \Honed\Core\Link\Link|null
     */
    protected $link = null;

    /**
     * Set the properties of the link.
     *
     * @param  \Honed\Core\Link\Link|(\Closure(\Honed\Core\Link\Link):(void|\Honed\Core\Link\Link))|(array<string,mixed>|string|\Closure(mixed...):string)|null  $link
     * @return $this
     */
    public function link(mixed $link = null, mixed $parameters = null, bool $absolute = true): static
    {
        if (\is_null($link)) {
            return $this;
        }

        $instance = $this->linkInstance();

        match (true) {
            $link instanceof Link => $this->setLink($link),
            \is_array($link) => $instance->assign($link),
            \is_callable($link) => $this->evaluate($link, [
                'link' => $instance,
                'route' => $instance,
                'url' => $instance,
            ], [
                Link::class => $instance,
            ]),
            default => $instance->link($link, $parameters, $absolute),
        };

        return $this;
    }

    /**
     * Create a new link instance if one is not already set.
     */
    public function linkInstance(): Link
    {
        return $this->link ??= Link::make();
    }

    /**
     * Override the link instance.
     */
    public function setLink(?Link $link)
    {
        if (\is_null($link)) {
            return;
        }

        $this->link = $link;
    }

    /**
     * Get the link instance.
     *
     * @return \Honed\Core\Link\Link|null
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Shortcut for setting a named route.
     *
     * @param  array<array-key, mixed>  $parameters
     * @return $this
     */
    public function route(string $name, mixed $parameters = [], bool $absolute = true): static
    {
        $this->linkInstance()->route($name, $parameters, $absolute);

        return $this;
    }

    /**
     * Shortcut for setting a url.
     *
     * @return $this
     */
    public function url(string $url): static
    {
        $this->linkInstance()->url($url);

        return $this;
    }

    /**
     * Determine if there is a link.
     *
     * @return bool
     */
    public function isLinkable()
    {
        return ! \is_null($this->link);
    }
}
