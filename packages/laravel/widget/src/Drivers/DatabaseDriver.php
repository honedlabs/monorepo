<?php

namespace Honed\Widget\Drivers;

use Honed\Widget\Facades\Widgets;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

class DatabaseDriver extends Driver
{
    /**
     * The database connection.
     *
     * @var \Illuminate\Database\DatabaseManager
     */
    protected $db;

    /**
     * The user configuration.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * The name of the "created at" column.
     *
     * @var string|null
     */
    public const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    public const UPDATED_AT = 'updated_at';

    /**
     * Create a new driver instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        Dispatcher $events,
        DatabaseManager $db,
    ) {
        parent::__construct($name, $events);

        $this->db = $db;
    }

    /**
     * {@inheritdoc}
     */
    public function get($scope)
    {
        return $this->newQuery()
            ->where('scope', Widgets::serializeScope($scope))
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function exists($widget, $scope)
    {
        return $this->newQuery()
            ->where('widget', $widget)
            ->where('scope', Widgets::serializeScope($scope))
            ->exists();
    }

    /**
     * {@inheritdoc}
     */
    public function set($widget, $scope, $order = 0)
    {
        $this->newQuery()
            ->upsert([
                'group' => $group,
                'name' => $widget,
                'scope' => Widgets::serializeScope($scope),
                'order' => $order,
                self::CREATED_AT => $now = Carbon::now(),
                self::UPDATED_AT => $now,
            ], [
                'name',
                'scope'
            ], [
                'order',
                self::UPDATED_AT,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function update($widget, $scope, $group = null, $order = 0)
    {
        return (bool) $this->newQuery()
            ->where('name', $widget)
            ->where('scope', Widgets::serializeScope($scope))
            ->where('group', $group)
            ->update([
                'order' => $order,
                self::UPDATED_AT => Carbon::now(),
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($widget, $scope, $group = null)
    {
        return (bool) $this->newQuery()
            ->where('name', $widget)
            ->where('scope', Widgets::serializeScope($scope))
            ->where('group', $group)
            ->delete();
    }
    

    /**
     * Create a new table query.
     */
    protected function newQuery(): Builder
    {
        return $this->connection()->table(
            $this->config->get("widget.drivers.{$this->name}.table") ?? 'widgets'
        );
    }

    /**
     * The database connection.
     */
    protected function connection(): Connection
    {
        return $this->db->connection(
            $this->config->get("widget.drivers.{$this->name}.connection") ?? null
        );
    }    
}
