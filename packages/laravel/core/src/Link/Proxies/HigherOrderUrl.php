<?php

declare(strict_types=1);

namespace Honed\Core\Link\Proxies;

use Honed\Core\Contracts\HigherOrder;
use Honed\Core\Primitive;

/**
 * @template T of \Honed\Core\Primitive
 *
 * @implements \Honed\Core\Contracts\HigherOrder<T>
 */
class HigherOrderUrl implements HigherOrder
{
    /**
     * @param  T  $primitive
     */
    public function __construct(
        protected readonly Primitive $primitive
    ) {}

    /**
     * Call the method on the URL class
     *
     * @return T
     */
    public function __call(string $name, array $arguments)
    {
        $primitive = $this->primitive;

        $primitive->makeUrl(); // @phpstan-ignore-line

        $url = $primitive->getUrl(); // @phpstan-ignore-line
        if ($url && method_exists($url, $name)) {
            $url->{$name}(...$arguments);
        }

        return $primitive;
    }
}
