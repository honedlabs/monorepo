<?php

declare(strict_types=1);

namespace Honed\Form\Components;

class Password extends Input
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->password();
    }
}
