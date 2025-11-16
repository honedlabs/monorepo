<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use Honed\Scaffold\Support\PendingInterface;
use Illuminate\Support\Collection;

trait HasInterfaces
{
    /**
     * The interfaces to be implemented.
     *
     * @var Collection<int, PendingInterface>
     */
    protected $interfaces;

    /**
     * Add an interface to the context.
     */
    public function addInterface(PendingInterface $interface): void
    {
        $this->interfaces->push($interface);
    }

    /**
     * Add multiple interfaces to the context.
     *
     * @param  list<PendingInterface>  $interfaces
     */
    public function addInterfaces(array $interfaces): void
    {
        $this->interfaces->push(...$interfaces);
    }

    /**
     * Get the interfaces for the context.
     *
     * @return Collection<int, PendingInterface>
     */
    public function getInterfaces(): Collection
    {
        return $this->interfaces;
    }

    /**
     * Create a new pending interface instance.
     */
    public function newInterface(): PendingInterface
    {
        return new PendingInterface();
    }

    /**
     * Initialize the interfaces.
     */
    protected function initializeInterfaces(): void
    {
        $this->interfaces = new Collection();
    }
}
