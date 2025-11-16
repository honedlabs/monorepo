<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use Honed\Scaffold\Support\PendingTrait;
use Illuminate\Support\Collection;

trait HasTraits
{
    /**
     * The traits to be used.
     *
     * @var Collection<int, PendingTrait>
     */
    protected $traits;

    /**
     * Add a trait to the context.
     */
    public function addTrait(PendingTrait $trait): void
    {
        $this->traits->push($trait);
    }

    /**
     * Add multiple traits to the context.
     *
     * @param  list<PendingTrait>  $traits
     */
    public function addTraits(array $traits): void
    {
        $this->traits->push(...$traits);
    }

    /**
     * Get the traits for the context.
     *
     * @return Collection<int, PendingTrait>
     */
    public function getTraits(): Collection
    {
        return $this->traits;
    }

    /**
     * Create a new pending trait instance.
     */
    public function newTrait(): PendingTrait
    {
        return new PendingTrait();
    }

    /**
     * Initialize the traits.
     */
    protected function initializeTraits(): void
    {
        $this->traits = new Collection();
    }
}
