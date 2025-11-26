<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use Honed\Scaffold\Support\InterfaceStatement;
use Illuminate\Support\Collection;

trait HasInterfaces
{
    /**
     * The interfaces to be implemented.
     *
     * @var Collection<int, InterfaceStatement>
     */
    protected $interfaces;

    /**
     * Add an interface to the context.
     */
    public function addInterface(InterfaceStatement $interface): void
    {
        $this->interfaces->push($interface);
    }

    /**
     * Add multiple interfaces to the context.
     *
     * @param  list<InterfaceStatement>  $interfaces
     */
    public function addInterfaces(array $interfaces): void
    {
        $this->interfaces->push(...$interfaces);
    }

    /**
     * Get the interfaces for the context.
     *
     * @return Collection<int, InterfaceStatement>
     */
    public function getInterfaces(): Collection
    {
        return $this->interfaces;
    }

    /**
     * Create a new pending interface instance.
     */
    public function newInterface(): InterfaceStatement
    {
        return new InterfaceStatement();
    }

    /**
     * Initialize the interfaces.
     */
    protected function initializeInterfaces(): void
    {
        $this->interfaces = new Collection();
    }
}
