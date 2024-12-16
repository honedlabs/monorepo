<?php

namespace Honed\Crumb;

use Honed\Core\Primitive;

class Crumb extends Primitive
{
    use \Honed\Core\Concerns\HasName;
    use \Honed\Core\Concerns\HasMeta;
    use Concerns\HasIcon;

    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $link;

    /**
     * Create a new crumb instance.
     * 
     * @param string|(\Closure(mixed...):string) $name
     * @param string|(\Closure(mixed...):string)|null $link
     * @param array<array-key, mixed> $meta
     */
    public function __construct(
        string|\Closure $name,
        string|\Closure $link = null,
        array $meta = [],
    ) {
        $this->setName($name);
        $this->setLink($link);
        $this->setMeta($meta);
    }

    /**
     * Create a new crumb instance.
     * 
     * @param string|(\Closure(mixed...):string) $name
     * @param string|(\Closure(mixed...):string)|null $link
     * @param array<array-key, mixed> $meta
     */
    public static function make(string|\Closure $name, string|\Closure $link = null, array $meta = [])
    {
        return resolve(static::class, compact('name', 'link', 'meta'));
    }

    public function setRoute(string $name, array $parameters = [], bool $absolute = true): void
    {
        $this->link = route($name, $parameters, $absolute);
    }

    public function setUrl(string $url): void
    {
        $this->link = $url;
    }

    public function setLink(string|\Closure $link, array $parameters = [], bool $absolute = true): void
    {
        if (\is_callable($link)) {
            $this->link = $link;
        }

        match (true) {
            \is_string($link) => $this->link = $this->url($link),
            default => $this->link = null,
        };
    }

    public function route(string $name, array $parameters = [], bool $absolute = true): string
    {
        return route($name, $parameters, $absolute);
    }

    public function url(string $url): string
    {
        return url($url);
    }

    public function link(string $link): static
    {
        $this->setLink($link);
        return $this;
    }

    public function getLink($named = [], $typed = []): ?string
    {
        return $this->evaluate($this->link, $named, $typed);
    }

    public function setIcon(string|null $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * Get the crumb as an array
     *
     * @return non-empty-array<'name'|'url'|'icon',string|null>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName([
                // ...$product
                // 'record'
                // 'page'
                // 'id'
            ], [
                // class-name
            ]),
            'url' => $this->getLink([

            ], [

            ]),
            ...($this->hasIcon() ? ['icon' => $this->getIcon()] : []),
        ];
    }
}
