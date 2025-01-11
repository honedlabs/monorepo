<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Destination;

trait HasDestination
{
    /**
     * Set the destination. 
     * 
     * @param \Honed\Core\Destination|\Closure|string $destination
     * @param \Honed\Core\Destination|\Closure|string $parameters
     * @return $this
     */
    public function to($destination, $parameters = null): static
    {

        match (true) {
            $destination instanceof Destination => $this->destination = $destination,
            ! \is_callable($destination) => $this->destination = $this->newDestination()->to($destination, $parameters),
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
     * Get the destination.
     */
    public function getDestination(): ?Destination
    {
        return $this->destination;
    }

    /**
     * Determine if the destination has been set.
     */
    public function hasDestination(): bool
    {
        return isset($this->destination);
    }

    /**
     * Resolve the destination.
     * 
     * @param mixed $parameters
     * @param array<string,mixed>|null $typed
     */
    public function resolveDestination($parameters = null, $typed = null): ?string
    {
        return $this->destination?->resolve($parameters, $typed);

    }

    /**
     * Access the destination for this instance.
     */
    private function newDestination(): Destination
    {
        return $this->destination ??= Destination::make();
    }
}
