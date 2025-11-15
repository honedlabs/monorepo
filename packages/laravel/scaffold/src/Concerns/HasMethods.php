<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use Illuminate\Support\Collection;
use Honed\Scaffold\Support\PendingMethod;

trait HasMethods
{
    /**
     * The methods to be added.
     *
     * @var Collection<int, PendingMethod>
     */
    protected $methods;

    /**
     * Initialize the methods.
     */
    protected function initializeMethods(): void
    {
        $this->methods = new Collection();
    }

    /**
     * Add a method to the context.
     */
    public function addMethod(PendingMethod $method): void
    {
        $this->methods->push($method);
    }

    /**
     * Get the methods for the context.
     *
     * @return Collection<int, PendingMethod>
     */
    public function getMethods(): Collection
    {
        return $this->methods;
    }

    /**
     * Create a new pending method instance.
     */
    public function newMethod(): PendingMethod
    {
        return new PendingMethod();
    }

    
}