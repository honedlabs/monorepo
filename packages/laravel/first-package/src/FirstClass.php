<?php

declare(strict_types=1);

namespace YourMonorepo\FirstPackage;

final class FirstClass
{
    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->name;
    }
}
