<?php

declare(strict_types=1);

namespace Honed\Persist\Contracts;

interface Driver
{
    /**
     * Retrieve the view for the given table, name, and scope from storage.
     *
     * @param  mixed  $table
     * @param  string  $name
     * @param  mixed  $scope
     * @return object|null
     */
    public function get($table, $name, $scope);

    /**
     * Set the view for the given table and scope.
     *
     * @param  mixed  $table
     * @param  string  $name
     * @param  mixed  $scope
     * @param  array<string, mixed>  $view
     * @return void
     */
    public function set($table, $name, $scope, $view);
}
