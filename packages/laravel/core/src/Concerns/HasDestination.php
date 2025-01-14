<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Destination;

trait HasDestination
{
    /**
     * @var \Honed\Core\Destination
     */
    protected $destination;

    /**
     * Set the destination for the instance.
     *
     * @param  \Honed\Core\Destination|\Closure|string|null  $destination
     * @return $this
     */
    public function destination($destination, mixed $parameters = null): static
    {
        match (true) {
            \is_null($destination) => null,
            $destination instanceof Destination => $this->destination = $destination,
            $this->callsDestination($destination) => \call_user_func($destination, $this->newDestination()),
            default => $this->newDestination()->to($destination, $parameters)
        };

        return $this;
    }

    /**
     * Alias for `destination`.
     *
     * @param  \Honed\Core\Destination|\Closure|string|null  $destination
     * @return $this
     */
    public function to($destination, mixed $parameters = null): static
    {
        return $this->destination($destination, $parameters);
    }

    /**
     * Get the destination for this instance.
     *
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model  $parameters
     * @param  array<string,mixed>  $typed
     */
    public function getDestination($parameters = [], $typed = []): ?Destination
    {
        $this->destination?->resolve($parameters, $typed);

        return $this->destination;
    }

    /**
     * Determine if the instance has a destination.
     */
    public function hasDestination(): bool
    {
        return ! \is_null($this->destination);
    }

    /**
     * Access the destination for this instance.
     */
    private function newDestination(): Destination
    {
        return $this->destination ??= Destination::make();
    }

    /**
     * Determine if the destination is a closure that modifies the destination on the instance.
     */
    private function callsDestination(mixed $destination): bool
    {
        if (! $destination instanceof \Closure) {
            return false;
        }

        $parameter = collect((new \ReflectionFunction($destination))->getParameters())->first();

        $type = $parameter->getType();

        return ($type instanceof \ReflectionNamedType && $type->getName() === Destination::class)
            || $parameter->getName() === 'destination';
    }
}
