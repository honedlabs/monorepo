<?php

declare(strict_types=1);

namespace Honed\Widget\Contracts;

interface Driver
{
    /**
     * Get all widgets for a given scope.
     *
     * @return array<int,mixed>
     */
    public function get(mixed $scope): array;

    /**
     * Set a widget for a given scope, widget name and group.
     */
    public function set(string $widget, mixed $scope, mixed $data = null, mixed $position = null): void;

    /**
     * Update the data and position of a widget for a given scope and widget.
     */
    public function update(string $widget, mixed $scope, mixed $data = null, mixed $position = null): bool;

    /**
     * Delete a widget for a given scope, widget name and group.
     */
    public function delete(string $widget, mixed $scope): bool;

    /**
     * Purge all widgets by scope from storage.
     */
    // public function purge(mixed $scope): void;
}
