<?php

namespace Honed\Lock\Concerns;

use Honed\Lock\Facades\Lock;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait HasAbilities
{
    /**
     * Define the abilities this model has.
     * 
     * @return array<string,bool>
     */
    abstract public function abilities();

    /**
     * Initialize the abilities trait for an instance.
     * 
     * @return void
     */
    public function initializeHasAbilities(): void
    {
        if (Lock::includeAbilities() && ! isset($this->appends['abilities'])) {
            $this->appends[] = 'abilities';
        }
    }

    /**
     * Retrieve the abilities this model has.
     * 
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function locks(): Attribute
    {
        return Attribute::get(fn () => $this->abilities());
    }

    /**
     * Hide the abilities from the model.
     * 
     * @return $this
     */
    public function withoutAbilities(): static
    {
        if (isset($this->appends['abilities'])) {
            $this->appends[] = 'abilities';
        }

        return $this;
    }

    /**
     * Make available the abilities from the model.
     * 
     * @return $this
     */
    public function withAbilities(): static
    {
        $this->appends = \array_diff($this->appends, ['abilities']);

        return $this;
    }
}
