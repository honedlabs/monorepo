<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use Honed\Scaffold\Support\PendingMethod;
use Illuminate\Support\Collection;

trait HasMethods
{
    /**
     * The methods to be added.
     *
     * @var Collection<int, PendingMethod>
     */
    protected $methods;

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

    /**
     * Initialize the methods.
     */
    protected function initializeMethods(): void
    {
        $this->methods = new Collection();
    }
}
