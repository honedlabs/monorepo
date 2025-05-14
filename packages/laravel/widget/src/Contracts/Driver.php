<?php

declare(strict_types=1);

namespace Honed\Widget\Contracts;

interface Driver
{
    public function store(string $name);
    
}