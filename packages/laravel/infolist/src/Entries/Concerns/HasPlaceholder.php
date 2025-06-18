<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

trait HasPlaceholder
{
    /**
     * The placeholder value to display if the entry is null.
     *
     * @var mixed
     */
    protected $placeholder = null;

    /**
     * Set the placeholder value to display.
     *
     * @param  mixed  $placeholder
     * @return $this
     */
    public function placeholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get the placeholder value to display.
     *
     * @return mixed
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }
}
