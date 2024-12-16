<?php

namespace Honed\Crumb;

use Honed\Core\Primitive;
use Illuminate\Routing\Route;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Route as FacadesRoute;

class Crumb extends Primitive
{
    use \Honed\Core\Concerns\HasName;
    use \Honed\Core\Concerns\HasMeta;
    use Concerns\HasIcon;
    use Concerns\HasLink;

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
     * Get the binding parameters to pass to a closure.
     * 
     * @return non-empty-array{array<string,mixed>,array<string,mixed>}
     */
    private function getClosureParameters(): array
    {
        $parameters = FacadesRoute::current()->parameters();
        $request = FacadesRequest::capture();
        $route = FacadesRoute::current();
        $values = array_values($parameters);

        $mapped = \array_combine(
            \array_map('get_class', $values),
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
