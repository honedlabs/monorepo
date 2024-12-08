<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Proxies;

use Honed\Core\Primitive;
use Honed\Core\Contracts\HigherOrder;

/**
 * @internal
 *
 * @template T of \Honed\Core\Primitive
 * @implements \Honed\Core\Contracts\HigherOrder<T>
 */
class HigherOrderFormatter implements HigherOrder
{
    /**
     * @param T $primitive
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

        if (!\property_exists($primitive, 'formatter') || $primitive->missingFormatter()) {
            return $primitive;
        }

        /**
         * @var \Honed\Core\Formatters\Contracts\Formatter
         */
        $formatter = $primitive->getFormatter(); // @phpstan-ignore-line
        if ($formatter && \method_exists($formatter, $name)) {
            $formatter->{$name}(...$arguments);
        }

        return $primitive;
    }
}
