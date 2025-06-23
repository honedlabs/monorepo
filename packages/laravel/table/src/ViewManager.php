<?php

declare(strict_types=1);

namespace Honed\Table;

use Closure;
use Honed\Table\Contracts\ViewScopeSerializeable;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use RuntimeException;

class ViewManager
{
    use Concerns\InteractsWithDatabase;

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
     * The default scope resolver.
     *
     * @var (Closure(string): mixed)|null
     */
    protected $defaultScopeResolver;

    /**
     * Indicates if the Eloquent "morph map" should be used when serializing.
     *
     * @var bool
     */
    protected $useMorphMap = false;

    /**
     * Create a new view resolver.
     *
     * @return void
     */
    public function __construct(
        protected Container $container,
    ) {}

    /**
     * Serialize the given scope for storage.
     *
     * @param  mixed  $scope
     * @return string
     *
     * @throws RuntimeException
     */
    public function serializeScope($scope)
    {
        return match (true) {
            $scope instanceof ViewScopeSerializeable => $scope->viewScopeSerialize(),
            $scope === null => '__laravel_null',
            is_string($scope) => $scope,
            is_numeric($scope) => (string) $scope,
            $scope instanceof Model
                && $this->useMorphMap => $scope->getMorphClass().'|'.(string) $scope->getKey(),
            $scope instanceof Model
                && ! $this->useMorphMap => $scope::class.'|'.(string) $scope->getKey(),
            default => throw new RuntimeException(
                'Unable to serialize the view scope to a string. You should implement the ViewScopeSerializeable contract.'
            )
        };
    }

    /**
     * Specify that the Eloquent morph map should be used when serializing.
     *
     * @param  bool  $value
     * @return $this
     */
    public function useMorphMap($value = true)
    {
        $this->useMorphMap = $value;

        return $this;
    }

    /**
     * Set the default scope resolver.
     *
     * @param  (callable(string): mixed)  $resolver
     * @return void
     */
    public function resolveScopeUsing($resolver)
    {
        $this->defaultScopeResolver = $resolver;
    }

    /**
     * Pending view retrieval
     */
    public function for($scope = null)
    {

    }

    public function all() {}


    /**
     * Retrieve the value for the given name and scope from storage.
     *
     * @param  string  $name
     * @param  mixed  $scope
     * @return object|null
     */
    public function retrieve($name, $scope)
    {
        return $this->newQuery()
            ->where('name', $name)
            ->where('scope', $this->serializeScope($scope))
            ->first();
    }

    /**
     * Set a feature flag's value.
     *
     * @param  string  $feature
     * @param  mixed  $scope
     * @param  mixed  $value
     */
    public function set($feature, $scope, $value): void
    {
        $now = Carbon::now();
        $this->newQuery()->upsert([
            'name' => $feature,
            'scope' => $this->serializeScope($scope),
            'view' => json_encode($value, flags: JSON_THROW_ON_ERROR),
            static::CREATED_AT => $now,
            static::UPDATED_AT => $now,
        ], uniqueBy: ['name', 'scope'], update: ['view', static::UPDATED_AT]);
    }


    /**
     * Update the value for the given feature and scope in storage.
     *
     * @param  string  $feature
     * @param  mixed  $scope
     * @param  mixed  $value
     * @return bool
     */
    protected function update($feature, $scope, $value)
    {
        return (bool) $this->newQuery()
            ->where('name', $feature)
            ->where('scope', $this->serializeScope($scope))
            ->update([
                'view' => json_encode($value, flags: JSON_THROW_ON_ERROR),
                static::UPDATED_AT => Carbon::now(),
            ]);
    }

    /**
     * Insert the table view for the given scope into storage.
     *
     * @param  Table|string  $name
     * @param  array<string, mixed>  $scope
     * @param  array<string, mixed>  $value
     * @return bool
     */
    public function insert($name, $scope, $value)
    {
        return $this->insertMany([[
            'name' => $name,
            'scope' => $scope,
            'view' => $value,
        ]]);
    }

    /**
     * Insert the table views into storage.
     *
     * @param  array<array<string, mixed>>  $inserts
     * @return bool
     */
    public function insertMany($inserts)
    {
        $now = Carbon::now();

        return $this->newQuery()->insert(array_map(fn ($insert) => [
            'name' => $insert['name'],
            'scope' => $this->serializeScope($insert['scope']),
            'view' => json_encode($insert['view'], flags: JSON_THROW_ON_ERROR),
            static::CREATED_AT => $now,
            static::UPDATED_AT => $now,
        ], $inserts));
    }

    /**
     * Delete a view.
     *
     * @param  Table|string  $name
     * @param  array<string, mixed>  $scope
     * @return void
     */
    public function delete($name, $scope)
    {
        $this->newQuery()
            ->where('name', $name)
            ->where('scope', static::serializeScope($scope))
            ->delete();
    }

    /**
     * The default scope resolver.
     *
     * @param  string  $driver
     * @return callable(): mixed
     */
    protected function defaultScopeResolver($driver)
    {
        return function () use ($driver) {
            if ($this->defaultScopeResolver !== null) {
                return ($this->defaultScopeResolver)($driver);
            }

            // @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible
            return $this->container['auth']->guard()->user();
        };
    }

    /**
     * Get the database manager instance from the container.
     *
     * @return DatabaseManager
     */
    protected function getDatabaseManager()
    {
        /** @var DatabaseManager */
        return $this->container['db']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }

    /**
     * Get the config instance from the container.
     *
     * @return Repository
     */
    protected function getConfig()
    {
        /** @var Repository */
        return $this->container['config']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }

    /**
     * Get the event dispatcher instance from the container.
     *
     * @return Dispatcher
     */
    protected function getDispatcher()
    {
        /** @var Dispatcher */
        return $this->container['events']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
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
        return $this->getDatabaseManager()
            ->connection($this->getConnection());
    }
}
