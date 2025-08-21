<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

trait CanBeAutofocused
{
    /**
     * Whether the component should be autofocused.
     * 
     * @var bool
     */
    protected $autofocused = false;

    /**
     * Set the autofocused state of the component.
     */
}