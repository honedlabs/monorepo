<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Illuminate\Support\Str;

trait HasLib
{
    /**
     * The location of the components.
     * 
     * @var string|null
     */
    protected $lib;

    /**
     * Set the location of the components.
     * 
     * @return $this
     */
    public function lib(string $value): static
    {
        $this->lib = $value;

        return $this;
    }

    /**
     * Get the location of the components.
     */
    public function getLib(): string
    {
        $lib = $this->lib ??= $this->getDefaultLib();

        return Str::finish($lib, '/');
    }

    /**
     * Get the default location of the components.
     */
    protected function getDefaultLib(): string
    {
        /** @var string */
        return config('form.lib', '@/Components');
    }
}