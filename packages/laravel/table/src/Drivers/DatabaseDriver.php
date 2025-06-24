<?php

declare(strict_types=1);

namespace Honed\Table\Drivers;

use Honed\Table\Concerns\InteractsWithDatabase;
use Honed\Table\Contracts\Driver;
use Honed\Table\Facades\Views;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Carbon;

class DatabaseDriver implements Driver
{
    use InteractsWithDatabase;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    public const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    public const UPDATED_AT = 'updated_at';

    /**
     * The database connection.
     *
     * @var DatabaseManager
     */
    protected $db;

    /**
     * The store's name.
     *
     * @var string
     */
    protected $name;

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * Create a new view resolver.
     */
    public function __construct(
        DatabaseManager $db,
        Dispatcher $events,
        string $name
    ) {
        $this->db = $db;
        $this->events = $events;
        $this->name = $name;
    }

    /**
     * Retrieve the value for the given name and scope from storage.
     *
     * @param  string  $table
     * @param  string  $name
     * @param  string  $scope
     * @return object|null
     */
    public function get($table, $name, $scope)
    {
        return $this->scoped($table, $name, $scope)->first();
    }

    /**
     * Retrieve the views for the given table and scopes from storage.
     *
     * @param  string  $table
     * @param  array<int, string>  $scopes
     * @return array<int, object>
     */
    public function list($table, $scopes)
    {
        return $this->newQuery()
            ->where('table', $table)
            ->whereIn('scope', $scopes)
            ->get(['id', 'name', 'view'])
            ->all();
    }

    /**
     * Set a view for the given table and scope.
     *
     * @param  string  $table
     * @param  string  $name
     * @param  string  $scope
     * @param  mixed  $view
     * @return void
     */
    public function set($table, $name, $scope, $view)
    {
        $this->newQuery()->upsert(
            $this->fill(compact('table', 'name', 'scope', 'view')),
            uniqueBy: ['table', 'scope', 'name'],
            update: ['view', static::UPDATED_AT]
        );
    }

    /**
     * Insert the table view for the given scope into storage.
     *
     * @param  string  $table
     * @param  string  $name
     * @param  mixed  $scope
     * @param  mixed  $view
     * @return bool
     */
    public function insert($table, $name, $scope, $view)
    {
        /** @var array<int, array{table: string, name: string, scope: mixed, view: mixed}> */
        $inserts = [
            $this->fill(compact('table', 'name', 'scope', 'view'))
        ];

        return $this->insertMany($inserts);
    }

    /**
     * Insert the table views into storage.
     *
     * @param  array<int, array{table: string, name: string, scope: mixed, view: mixed}>  $inserts
     * @return bool
     */
    public function insertMany($inserts)
    {
        return $this->newQuery()->insert(
            array_map(fn ($insert) => $this->fill($insert), $inserts)
        );
    }

    /**
     * Delete a view.
     *
     * @param  string  $table
     * @param  string  $name
     * @param  string  $scope
     * @return void
     */
    public function delete($table, $name, $scope)
    {
        $this->scoped($table, $name, $scope)->delete();
    }

    /**
     * Purge all views for the given table.
     *
     * @param  array<int, string>|null  $table
     * @return void
     */
    public function purge($table = null)
    {
        if ($table === null) {
            $this->newQuery()->delete();
        } else {
            $this->newQuery()
                ->whereIn('table', $table)
                ->delete();
        }
    }

    /**
     * Update the value for the given feature and scope in storage.
     *
     * @param  string  $table
     * @param  string  $name
     * @param  string  $scope
     * @param  mixed  $value
     * @return bool
     */
    public function update($table, $name, $scope, $value)
    {
        return (bool) $this->scoped($table, $name, $scope)
            ->update([
                'view' => json_encode($value, flags: JSON_THROW_ON_ERROR),
                static::UPDATED_AT => Carbon::now(),
            ]);
    }

    /**
     * Get a new query builder for the given table, name, and scope.
     *
     * @param  string  $table
     * @param  string  $name
     * @param  string  $scope
     * @return \Illuminate\Database\Query\Builder
     */
    protected function scoped($table, $name, $scope)
    {
        return $this->newQuery()
            ->where('table', $table)
            ->where('name', $name)
            ->where('scope', $scope);
    }

    /**
     * Create an array of values for the given insert.
     *
     * @param  array{table: string, name: string, scope: mixed, view: mixed}  $insert
     * @return array<string, mixed>
     */
    protected function fill($insert)
    {
        $now = Carbon::now();

        return [
            'name' => $insert['name'],
            'table' => Views::serializeTable($insert['table']),
            'scope' => Views::serializeScope($insert['scope']),
            'view' => json_encode($insert['view'], flags: JSON_THROW_ON_ERROR),
            static::CREATED_AT => $now,
            static::UPDATED_AT => $now,
        ];
    }

    /**
     * Create a new table query.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newQuery()
    {
        return $this->connection()
            ->table($this->getTableName());
    }

    /**
     * The database connection.
     *
     * @return \Illuminate\Database\Connection
     */
    protected function connection()
    {
        return $this->db->connection($this->getConnection());
    }
}
