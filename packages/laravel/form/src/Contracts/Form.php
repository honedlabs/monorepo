<?php

declare(strict_types=1);

namespace Honed\Form\Contracts;

interface Form
{
    /**
     * Get the default values to be used for the form.
     * 
     * @return array<string, mixed>
     */
    public function getDefaults();
}
