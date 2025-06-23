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
     * 
     */

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
     * Get the table name for the given table.
     *
     * @param  string|Table  $table
     * @return string
     */
    public function getTableName($table)
    {
        return match (true) {
            $table instanceof Table => $table::class,
            default => $table,
        };
    }

    /**
     * Create a pending view retrieval.
     * 
     * @param mixed $scope
     * @return PendingViewRetrieval
     */
    public function for($scope = null)
    {


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
     * Dynamically call the default store instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->store()->$method(...$parameters);
    }
}
