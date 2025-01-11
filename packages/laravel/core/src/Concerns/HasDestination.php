<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Destination;
use Laravel\SerializableClosure\Support\ReflectionClosure;

trait HasDestination
{
    /**
     * Set the destination. 
     * 
     * @param \Honed\Core\Destination|\Closure|string $destination
     * @param mixed $parameters
     * @return $this
     */
    public function destination($destination, $parameters = null): static
    {

        match (true) {
            $destination instanceof Destination => $this->destination = $destination,
            !\is_callable($destination) => $this->destination = $this->newDestination()->to($destination, $parameters),
            collect((new \ReflectionFunction($destination))->getParameters())
                ->some(fn (\ReflectionParameter $parameter) => 
                    ($t = $parameter->getType()) instanceof \ReflectionNamedType && $t->getName() === Destination::class
                        || \in_array($parameter->getName(), ['destination', 'url', 'link'])
            ) => $this->destination = \call_user_func($destination, $this->newDestination()),
            default => $this->newDestination()->to($destination, $parameters)
        };

        return $this;
    }

    /**
     * Alias for `destination`.
     * 
     * @param \Honed\Core\Destination|\Closure|string $destination
     * @param mixed $parameters
     * @return $this
     */
    public function to($destination, $parameters = null): static
    {
        return $this->destination($destination, $parameters);
    }

    /**
     * @return \Honed\Core\Destination|null
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     */
    public function hasDestination(): bool
    {
        return isset($this->destination);
    }

    /**
     * @return \Honed\Core\Destination|null
     */
    public function resolveDestination($parameters = null, $typed = null)
    {
        return $this->destination?->resolve($parameters, $typed);

    }

    private function newDestination()
    {
        return $this->destination ??= Destination::make();
    }
}
