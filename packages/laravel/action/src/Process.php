<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Action\Concerns\CanBeTransaction;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Pipeline;
use RuntimeException;
use Throwable;

/**
 * @template TPayload
 * @template TResult
 */
abstract class Process
{
    use CanBeTransaction;

    /**
     * The container implementation.
     *
     * @var \Illuminate\Contracts\Container\Container|null
     */
    protected $container;

    /**
     * Create a new class instance.
     *
     * @param  \Illuminate\Contracts\Container\Container|null  $container
     * @return void
     */
    public function __construct(?Container $container = null)
    {
        $this->container = $container;
    }
    /**
     * The tasks to be sequentially executed.
     *
     * @return array<int, class-string>
     */
    abstract protected function tasks();

    /**
     * Create a new instance of the process.
     * 
     * @return static
     */
    public static function make()
    {
        return resolve(static::class);
    }

    /**
     * Run the process with exception handling.
     *
     * @param  TPayload  $payload
     * @return TResult
     */
    public function run($payload)
    {
        try {
            return $this->handle($payload);
        } catch (Throwable $e) {
            return $this->failure($e);
        }
    }

    /**
     * Handle the process without exception handling.
     *
     * @param  TPayload  $payload
     * @return TResult
     */
    public function handle($payload)
    {
        return $this->transact(
            fn () => $this->pipe($payload)
        );
    }

    /**
     * Get the container instance.
     *
     * @return \Illuminate\Contracts\Container\Container
     *
     * @throws \RuntimeException
     */
    protected function getContainer()
    {
        if (! $this->container) {
            throw new RuntimeException('A container instance has not been passed to the Pipeline.');
        }

        return $this->container;
    }

    /**
     * Set the container instance.
     *
     * @param  \Illuminate\Contracts\Container\Container  $container
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Handle the failure of the process.
     *
     * @param  Throwable  $throwable
     * @return mixed
     */
    protected function failure($throwable)
    {
        return false;
    }

    /**
     * The method to call on each pipe.
     *
     * @return string
     */
    protected function method()
    {
        return 'handle';
    }

    /**
     * Execute the pipeline.
     *
     * @param  TPayload  $payload
     * @return TResult
     */
    protected function pipe($payload)
    {
        return Pipeline::send($payload)
            ->through($this->pipelines())
            ->via($this->method())
            ->thenReturn();
    }

    /**
     * Generate the pipelines with closures.
     * 
     * @return array<int, callable>
     */
    protected function pipelines()
    {
        return \array_map(
            fn ($task) => is_callable($task) 
                ? $task
                : fn ($payload, $next) => $next(
                    $this->getContainer()
                        ->make($task)
                        ->{$this->method()}($payload)
                ),
            $this->tasks()
        );
    }
}
