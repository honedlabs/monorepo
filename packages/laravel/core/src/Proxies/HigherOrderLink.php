<?php

declare(strict_types=1);

namespace Honed\Core\Proxies;

use Honed\Core\Contracts\HigherOrder;
use Honed\Core\Primitive;

/**
 * @template T of \Honed\Core\Primitive
 *
 * @implements \Honed\Core\Contracts\HigherOrder<T>
 */
class HigherOrderLink implements HigherOrder
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

        $primitive->linkInstance(); // @phpstan-ignore-line

        $url = $primitive->getLink(); // @phpstan-ignore-line
        if ($url && method_exists($url, $name)) {
            $url->{$name}(...$arguments);
        }

        return $primitive;
    }
}
