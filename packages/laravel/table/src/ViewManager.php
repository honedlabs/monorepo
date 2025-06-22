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
     * @param  array<string, (callable(mixed $scope): mixed)>  $featureStateResolvers
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
                && $this->useMorphMap => $scope->getMorphClass().'|'.$scope->getKey(),
            $scope instanceof Model
                && ! $this->useMorphMap => $scope::class.'|'.$scope->getKey(),
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

    public function for($scope) {}

    public function all() {}

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

        return $this->newQuery()->insert(array_map(static fn ($insert) => [
            'name' => $insert['name'],
            'scope' => static::serializeScope($insert['scope']),
            'view' => json_encode($insert['view'], flags: JSON_THROW_ON_ERROR),
            static::CREATED_AT => $now,
            static::UPDATED_AT => $now,
        ], $inserts));
    }

    /**
     * Retrieve the value for the given feature and scope from storage.
     *
     * @param  string  $feature
     * @param  mixed  $scope
     * @return object|null
     */
    public function retrieve($name, $scope)
    {
        return $this->newQuery()
            ->where('name', $name)
            ->where('scope', static::serializeScope($scope))
            ->first();
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
        return $this->container['db'];
    }

    /**
     * Get the config instance from the container.
     *
     * @return Repository
     */
    protected function getConfig()
    {
        /** @var Repository */
        return $this->container['config'];
    }

    /**
     * Get the event dispatcher instance from the container.
     *
     * @return Dispatcher
     */
    protected function getDispatcher()
    {
        /** @var Dispatcher */
        return $this->container['events'];
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
