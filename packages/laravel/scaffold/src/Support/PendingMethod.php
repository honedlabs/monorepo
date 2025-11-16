<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

use Honed\Scaffold\Concerns\Annotatable;
use Honed\Scaffold\Concerns\Attributable;
use Honed\Scaffold\Concerns\Writable;

class PendingMethod extends PendingHelper
{
    use Annotatable;
    use Attributable;
    use Writable;

    /**
     * The signature of the method.
     *
     * @var string
     */
    protected $signature;

    /**
     * The visibility of the method.
     *
     * @var 'public'|'protected'|'private'
     */
    protected $visibility = 'public';

    /**
     * Whether the method is static.
     *
     * @var bool
     */
    protected $static = false;

    /**
     * Set the signature of the method.
     *
     * @return $this
     */
    public function signature(string $signature): static
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Set the visibility of the method.
     *
     * @param  'public'|'protected'|'private'  $visibility
     */
    public function visibility(string $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Set the visibility to public.
     */
    public function public(): static
    {
        return $this->visibility('public');
    }

    /**
     * Set the visibility to protected.
     */
    public function protected(): static
    {
        return $this->visibility('protected');
    }

    /**
     * Set the visibility to private.
     */
    public function private(): static
    {
        return $this->visibility('private');
    }

    /**
     * Set the method to be static.
     */
    public function static(bool $value = true): static
    {
        $this->static = $value;

        return $this;
    }

    /**
     * Add an override attribute to the method if supported.
     *
     * @return $this
     */
    public function override(): static
    {
        if ($this->isPhp(8.3)) {
            $this->attribute('\\Override');
        }

        return $this;
    }
}
