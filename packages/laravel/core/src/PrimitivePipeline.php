<?php

declare(strict_types=1);

namespace Honed\Core;

use Honed\Core\Exceptions\PipeNotFoundException;
use Illuminate\Support\Facades\Pipeline;

class PrimitivePipeline
{
    /**
     * Whether the pipeline has been run.
     *
     * @var bool
     */
    protected $completed = false;

    /**
     * The pipes to be run through.
     *
     * @var list<class-string<Pipe>>
     */
    protected $pipes = [];

    /**
     * Make a new instance of the pipeline.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Overwrite the pipes to be run through.
     *
     * @param  class-string<Pipe>|list<class-string<Pipe>>  $pipes
     * @return $this
     */
    public function throughAll(string|array $pipes): static
    {
        // @phpstan-ignore-next-line assign.propertyType
        $this->pipes = is_array($pipes) ? $pipes : func_get_args();

        return $this;
    }

    /**
     * Get the pipes to be run through.
     *
     * @return list<class-string<Pipe>>
     */
    public function getPipes(): array
    {
        return $this->pipes;
    }

    /**
     * Set the pipe to be run through.
     *
     * @param  class-string<Pipe>  $pipe
     */
    public function through(string $pipe): static
    {
        $this->pipes[] = $pipe;

        return $this;
    }

    /**
     * Set the first pipe to be run through.
     *
     * @param  class-string<Pipe>  $pipe
     */
    public function firstThrough(string $pipe): static
    {
        array_unshift($this->pipes, $pipe);

        return $this;
    }

    /**
     * Set the pipe to be run after another pipe.
     *
     * @param  class-string<Pipe>  $pipe
     * @param  class-string<Pipe>  $after
     * @return $this
     *
     * @throws PipeNotFoundException
     */
    public function throughAfter(string $pipe, string $after): static
    {
        $index = array_search($after, $this->pipes);

        if ($index === false) {
            PipeNotFoundException::throw($after);
        }

        array_splice($this->pipes, $index + 1, 0, $pipe);

        return $this;
    }

    /**
     * Set the pipe to be run before another pipe.
     *
     * @param  class-string<Pipe>  $pipe
     * @param  class-string<Pipe>  $before
     * @return $this
     *
     * @throws PipeNotFoundException
     */
    public function throughBefore(string $pipe, string $before): static
    {
        $index = array_search($before, $this->pipes);

        if ($index === false) {
            PipeNotFoundException::throw($before);
        }

        array_splice($this->pipes, $index, 0, $pipe);

        return $this;
    }

    /**
     * Set the last pipe to be run through.
     *
     * @param  class-string<Pipe>  $pipe
     */
    public function lastThrough(string $pipe): static
    {
        return $this->through($pipe);
    }

    /**
     * Determine if the pipeline has been completed.
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }

    /**
     * Reset the completed state of the pipeline.
     *
     * @return $this
     */
    public function reset(): static
    {
        $this->completed = false;

        return $this;
    }

    /**
     * Handle the pipeline.
     *
     * @return $this
     */
    public function handle(Primitive $primitive): static
    {
        if ($this->isCompleted()) {
            return $this;
        }

        $primitive->define();

        foreach ($this->getPipes() as $pipe) {
            resolve($pipe)->handle(
                $primitive,
                static fn ($primitive) => $primitive
            );
        }

        $this->completed = true;

        return $this;
    }
}
