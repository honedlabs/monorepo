<?php

declare(strict_types=1);

namespace Honed\Table\Drivers;

use Honed\Table\Contracts\Driver;
use Honed\Table\Facades\Views;
use Illuminate\Contracts\Events\Dispatcher;

class ArrayDriver implements Driver
{
    /**
     * The store's name.
     *
     * @var string
     */
    protected $name;

    /**
     * The event dispatcher.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * The resolved views.
     *
     * @var array<int, array<string, mixed>>
     */
    protected $resolved = [];

    /**
     * Create a new view resolver.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     * @param string $name
     */
    public function __construct(
        Dispatcher $events,
        string $name
    ) {
        $this->events = $events;
        $this->name = $name;
    }

        /**
     * Retrieve the view for the given table, name, and scope from storage.
     *
     * @param  string  $table
     * @param  string  $name
     * @param  mixed  $scope
     * @return object|null
     */
    public function get($table, $name, $scope)
    {
        $scopeKey = Views::serializeScope($scope);

        if (isset($this->resolved[$table][$name][$scopeKey])) {
            return $this->resolved[$table][$name][$scopeKey];
        }

        return null;
    }

    /**
     * Retrieve the views for the given table and scopes from storage.
     *
     * @param  string  $table
     * @param  array<mixed>  $scopes
     * @return array<object>
     */
    public function list($table, $scopes)
    {
        $views = [];

        foreach ($this->resolved[$table] ?? [] as $name => $scopedViews) {
            foreach ($scopedViews as $scopeKey => $view) {
                if (in_array($scopeKey, $scopes)) {
                    $views[] = $view;
                }
            }
        }
        return $views;
    }

    /**
     * Set the view for the given table and scope.
     *
     * @param  string  $table
     * @param  string  $name
     * @param  mixed  $scope
     * @param  array<string, mixed>  $value
     * @return void
     */
    public function set($table, $name, $scope, $value)
    {
        $scopeKey = Views::serializeScope($scope);
        $this->resolved[$table][$name][$scopeKey] = $value;
    }

    /**
     * Delete the view for the given table and scope from storage.
     *
     * @param  string  $table
     * @param  string  $name
     * @param  mixed  $scope
     * @return void
     */
    public function delete($table, $name, $scope)
    {
        $scopeKey = Views::serializeScope($scope);

        unset($this->resolved[$table][$name][$scopeKey]);
    }

    /**
     * Purge all views for the given table.
     *
     * @param  string  $table
     * @return void
     */
    public function purge($table)
    {
        unset($this->resolved[$table]);
    }
}