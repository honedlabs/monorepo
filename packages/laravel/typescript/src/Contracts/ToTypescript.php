<?php

declare(strict_types=1);

namespace Honed\Typescript\Contracts;

interface ToTypescript
{
    /**
     * Get the type to be used in the typescript definition.
     * 
     * @return string|array<string,mixed>
     */
    public function toTypescript();
}