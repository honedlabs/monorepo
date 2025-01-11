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
class HigherOrderFormatter implements HigherOrder
{
    /**
     * @param  T  $primitive
     */
    public function __construct(
        protected readonly Primitive $primitive
    ) {}

    /**
     * Call the method on the Formatter class
     *
     * @return T
     */
    public function __call(string $name, array $arguments)
    {
        $primitive = $this->primitive;

        /** @phpstan-ignore-next-line */
        if (! \property_exists($primitive, 'formatter') || ! $primitive->hasFormatter()) {
            return $primitive;
        }

        /**
         * @var \Honed\Core\Contracts\Formatter
         */
        $formatter = $primitive->getFormatter(); // @phpstan-ignore-line

        if (\method_exists($formatter, $name)) {
            $formatter->{$name}(...$arguments);
        }

        return $primitive;
    }
}
