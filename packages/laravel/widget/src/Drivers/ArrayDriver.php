<?php

declare(strict_types=1);

namespace Honed\Widget\Drivers;

class ArrayDriver extends Driver
{
    /**
     * {@inheritdoc}
     */
    public function get(mixed $scope): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $widget, mixed $scope, mixed $data = null, mixed $position = null): void {}

    /**
     * {@inheritdoc}
     */
    public function update(string $widget, mixed $scope, mixed $data = null, mixed $position = null): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $widget, mixed $scope): bool
    {
        return false;
    }
}
