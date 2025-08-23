<?php

namespace Honed\Widget\Contracts;

use Illuminate\Database\Eloquent\Attributes\Scope;

interface Driver
{
    /**
     * Get all widgets for a given scope.
     * 
     * @param string|null $scope
     * @return array<int,mixed>
     */
    public function get($scope);

    /**
     * Set a widget for a given scope, widget name and group.
     * 
     * @param string $widget
     * @param string $scope
     * @param string|null $group
     * @param int $order
     * @return void
     */
    public function set($widget, $scope, $data = null, $position = null);

    /**
     * Update the data and position of a widget for a given scope and widget.
     * 
     * @param string $widget
     * @param string $scope
     * @param string|null $group
     * @param int $order
     * @return bool
     */
    public function update($widget, $scope, $data = null, $position = null);

    /**
     * Delete a widget for a given scope, widget name and group.
     * 
     * @param string $widget
     * @param string $scope
     * @param string|null $group
     * @return void
     */
    public function delete($widget, $scope);

    /**
     * Purge all widgets by name from storage.
     * 
     * @param string|iterable<int, string> ...$widgets
     * @return void
     */
    // public function purge(...$widgets);
}