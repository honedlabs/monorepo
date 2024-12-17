<?php

declare(strict_types=1);

namespace Honed\Crumb;

use Honed\Core\Primitive;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class Crumb extends Primitive
{
    use Concerns\HasIcon;
    use Concerns\HasLink;
    use \Honed\Core\Concerns\HasMeta;
    use \Honed\Core\Concerns\HasName;

    /**
     * @var non-empty-array<int,array<string,mixed>>|null
     */
    protected $parameters;

    /**
     * Create a new crumb instance.
     *
     * @param  string|(\Closure(mixed...):string)  $name
     * @param  string|(\Closure(mixed...):string)|null  $link
     */
    public function __construct(
        string|\Closure $name,
        string|\Closure|null $link = null,
        ?string $icon = null,
    ) {
        $this->setName($name);
        $this->setLink($link);
        $this->setIcon($icon);
    }

    /**
     * Make a new crumb instance.
     *
     * @param  string|(\Closure(mixed...):string)  $name
     * @param  string|(\Closure(mixed...):string)|null  $link
     * @return $this
     */
    public static function make(string|\Closure $name, string|\Closure|null $link = null, ?string $icon = null): static
    {
        return resolve(static::class, compact('name', 'link', 'icon'));
    }

    /**
     * Get the crumb as an array
     *
     * @return non-empty-array<'name'|'url'|'icon',string|null>
     */
    public function toArray(): array
    {
        [$named, $typed] = $this->getClosureParameters();

        return [
            'name' => $this->getName($named, $typed),
            'url' => $this->getLink($named, $typed),
            ...($this->hasIcon() ? ['icon' => $this->getIcon()] : []),
        ];
    }

    /**
     * Determine if the current route corresponds to this crumb.
     */
    public function isCurrent(): bool
    {
        [$named, $typed] = $this->getClosureParameters();

        $this->link = $this->getLink($named, $typed);

        return (bool) $this->link ? Request::url() === url($this->link) : false;
    }

    /**
     * Get the binding parameters to pass to a closure.
     *
     * @return non-empty-array<int,array<string,mixed>>
     */
    private function getClosureParameters(): array
    {
        return $this->parameters ??= $this->makeClosureParameters();
    }

    /**
     * Get the binding parameters from the current route actions.
     *
     * @return non-empty-array<int,array<string,mixed>>
     */
    private function makeClosureParameters(): array
    {
        $parameters = Route::current()?->parameters() ?? [];
        $request = Request::capture();
        $route = Route::current();
        $values = \array_values($parameters);

        $mapped = \array_combine(
            \array_map(static fn ($value) => \is_object($value) ? \get_class($value) : \gettype($value), $values),
            $values
        );

        return [
            [
                'request' => $request,
                'route' => $route,
                ...$parameters,
            ],
            [
                Request::class => $request,
                Route::class => $route,
                ...$mapped,
            ],
        ];
    }
}
