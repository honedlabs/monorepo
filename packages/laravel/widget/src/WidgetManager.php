<?php

declare(strict_types=1);

namespace Honed\Widget;

use BackedEnum;
use Closure;
use Honed\Widget\Contracts\Driver;
use Honed\Widget\Contracts\SerializesScope;
use Honed\Widget\Drivers\ArrayDriver;
use Honed\Widget\Drivers\DatabaseDriver;
use Honed\Widget\Drivers\Decorator;
use Honed\Widget\Models\Widget as WidgetModel;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Cookie\CookieJar;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use InvalidArgumentException;
use RuntimeException;

/**
 * @mixin \Honed\Widget\Drivers\Decorator
 */
class WidgetManager
{
    /**
     * The container instance.
     *
     * @var Container
     */
    protected $container;

    /**
     * The array of resolved Widget drivers.
     *
     * @var array<string, Decorator>
     */
    protected $stores = [];

    /**
     * The registered custom drivers.
     *
     * @var array<string, Closure(Container, array<string, mixed>):Driver>
     */
    protected $customCreators = [];

    /**
     * The default scope resolver.
     *
     * @var (callable():mixed)|null
     */
    protected $defaultScopeResolver;

    /**
     * Whether the Eloquent "morph map" should be used when serializing
     * the widget.
     *
     * @var bool
     */
    protected $useMorphMap = false;

    /**
     * Create a new Widget manager instance.
     *
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Dynamically call the default store instance.
     *
     * @param  string  $method
     * @param  array<int, mixed>  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->store()->{$method}(...$parameters);
    }

    /**
     * Get the widget model class.
     *
     * @return class-string<Model>
     */
    public function model(): string
    {
        /** @var class-string<Model> */
        return $this->getConfig()->get('widget.model', WidgetModel::class);
    }

    /**
     * Get a widget store instance.
     *
     * @throws InvalidArgumentException
     */
    public function store(?string $store = null): Decorator
    {
        return $this->driver($store);
    }

    /**
     * Get a widget store instance by name.
     *
     * @throws InvalidArgumentException
     */
    public function driver(?string $name = null): Decorator
    {
        $name = $name ?: $this->getDefaultDriver();

        return $this->stores[$name] = $this->get($name);
    }

    /**
     * Attempt to get the driver from the local cache.
     *
     * @param  string  $name
     * @return Decorator
     *
     * @throws Exceptions\UndefinedDriverException
     * @throws Exceptions\InvalidDriverException
     */
    public function get($name)
    {
        return $this->drivers[$name] ?? $this->resolve($name);
    }

    /**
     * Create an instance of the array driver.
     */
    public function createArrayDriver(string $name): ArrayDriver
    {
        return new ArrayDriver(
            $name,
            $this->getDispatcher()
        );
    }

    /**
     * Create an instance of the database driver.
     */
    public function createDatabaseDriver(string $name): DatabaseDriver
    {
        return new DatabaseDriver(
            $name,
            $this->getDispatcher(),
            $this->getDatabaseManager(),
        );
    }

    /**
     * Get the default driver name.
     */
    public function getDefaultDriver(): string
    {
        /** @var string */
        return $this->getConfig()->get('widget.default', 'database');
    }

    /**
     * Set the default driver name.
     */
    public function setDefaultDriver(string $name): void
    {
        $this->getConfig()->set('widget.default', $name);
    }

    /**
     * Unset the given store instances.
     *
     * @param  string|array<int, string>|null  $name
     * @return $this
     */
    public function forgetDriver(string|array|null $name = null): static
    {
        $name ??= $this->getDefaultDriver();

        foreach ((array) $name as $driverName) {
            if (isset($this->stores[$driverName])) {
                unset($this->stores[$driverName]);
            }
        }

        return $this;
    }

    /**
     * Forget all of the resolved store instances.
     *
     * @return $this
     */
    public function forgetDrivers(): static
    {
        $this->stores = [];

        return $this;
    }

    /**
     * Register a custom driver creator Closure.
     *
     * @param  Closure(string, Container): Driver  $callback
     * @return $this
     */
    public function extend(string $driver, Closure $callback): static
    {
        $this->customCreators[$driver] = $callback->bindTo($this, $this);

        return $this;
    }

    /**
     * Serialize the given scope for storage.
     *
     *
     * @throws RuntimeException
     */
    public function serializeScope(mixed $scope): string
    {
        return match (true) {
            $scope instanceof SerializesScope => $scope->serializeScope(),
            is_string($scope) => $scope,
            is_numeric($scope) => (string) $scope,
            $scope instanceof Model && $this->useMorphMap => $scope->getMorphClass().'|'.$scope->getKey(), // @phpstan-ignore binaryOp.invalid
            $scope instanceof Model && ! $this->useMorphMap => $scope::class.'|'.$scope->getKey(), // @phpstan-ignore binaryOp.invalid
            default => throw new RuntimeException(
                'Unable to serialize the scope to a string. You should implement the ['.SerializesScope::class.'] contract.'
            )
        };
    }

    /**
     * Serialize the widget for storage.
     */
    public function serializeWidget(string|Widget|BackedEnum $widget): string
    {
        // Refactor
        $widget = match (true) {
            is_string($widget) => $widget,
            $widget instanceof Widget => $widget->getName(),
            default => $widget->value,
        };

        if (class_exists($widget)
            && is_subclass_of($widget, Widget::class)
            && $name = $this->container->make($widget)->getName()
        ) {
            return $name;
        }

        return $widget;
    }

    /**
     * Specify that the Eloquent morph map should be used when serializing.
     *
     * @return $this
     */
    public function useMorphMap(bool $value = true): static
    {
        $this->useMorphMap = $value;

        return $this;
    }

    /**
     * Determine if the Eloquent morph map should be used when serializing.
     */
    public function usesMorphMap(): bool
    {
        return $this->useMorphMap;
    }

    /**
     * Set the default scope resolver.
     *
     * @param  (callable(): mixed)  $resolver
     */
    public function resolveScopeUsing(callable $resolver): void
    {
        $this->defaultScopeResolver = $resolver;
    }

    /**
     * The default scope resolver.
     *
     * @return callable(): mixed
     */
    public function defaultScopeResolver(string $driver): callable
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
     * Convert a grid position to a CSS grid area.
     */
    public function convertToGridArea(string $position): string
    {
        $parts = explode(':', $position);

        $from = $parts[0];
        $to = $parts[1] ?? null;

        if (strlen($from) < 2 || ($to && strlen($to) < 2)) {
            return '';
        }

        $fromColumnNumber = substr($from, 1);
        $areaFrom = "{$fromColumnNumber} / {$this->indexInAlphabet($from[0])}";

        if (! $to) {
            return $areaFrom;
        }

        $toStart = ((int) substr($to, 1)) + 1;

        $toEnd = ((int) $this->indexInAlphabet($to[0])) + 1;

        return "{$areaFrom} / {$toStart} / {$toEnd}";
    }

    /**
     * Get the index of the given letter in the alphabet.
     */
    protected function indexInAlphabet(string $letter): int
    {
        return ord($letter) - ord('A') + 1;
    }

    /**
     * Resolve the given driver.
     *
     * @throws InvalidArgumentException
     */
    protected function resolve(string $name): Decorator
    {
        if (isset($this->customCreators[$name])) {
            $driver = $this->callCustomCreator($name);
        } else {
            $method = 'create'.ucfirst($name).'Driver';

            if (method_exists($this, $method)) {
                /** @var Driver */
                $driver = $this->{$method}($name);
            } else {
                throw new InvalidArgumentException(
                    "Driver [{$name}] not supported."
                );
            }
        }

        return new Decorator(
            $name,
            $driver,
            $this->defaultScopeResolver($name),
            $this->container,
        );
    }

    /**
     * Call a custom driver creator.
     */
    protected function callCustomCreator(string $name): Driver
    {
        return $this->customCreators[$name]($name, $this->container);
    }

    /**
     * Get the database manager instance from the container.
     */
    protected function getDatabaseManager(): DatabaseManager
    {
        /** @var DatabaseManager */
        return $this->container['db']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }

    /**
     * Get the config instance from the container.
     */
    protected function getConfig(): Repository
    {
        /** @var Repository */
        return $this->container['config']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }

    /**
     * Get the event dispatcher instance from the container.
     */
    protected function getDispatcher(): Dispatcher
    {
        /** @var Dispatcher */
        return $this->container['events']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }

    /**
     * Get the cookie jar instance from the container.
     */
    protected function getCookieJar(): CookieJar
    {
        /** @var CookieJar */
        return $this->container['cookie']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }

    /**
     * Get the request instance from the container.
     */
    protected function getRequest(): Request
    {
        /** @var Request */
        return $this->request ??
            $this->container['request']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }

    /**
     * Get the session manager instance from the container.
     */
    protected function getSession(): SessionManager
    {
        /** @var SessionManager */
        return $this->session ??
            $this->container['session']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible
    }
}
