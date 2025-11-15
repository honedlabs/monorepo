<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use Closure;
use Illuminate\Contracts\Support\Arrayable;

trait Writable
{
    /**
     * The lines of the file to be written.
     *
     * @var list<string>
     */
    protected $lines = [];

    /**
     * Add a line.
     *
     * @return $this
     */
    public function line(string $line = ''): static
    {
        $this->lines[] = $line;

        return $this;
    }

    /**
     * Add multiple lines.
     *
     * @param  list<string>  $lines
     * @return $this
     */
    public function lines(array $lines): static
    {
        $this->lines = array_merge($this->lines, $lines);

        return $this;
    }

    /**
     * Add a line for each item.
     *
     * @template T
     *
     * @param  list<T>|Arrayable<T>  $items
     * @param  Closure($this, T): void  $callback
     * @return $this
     */
    public function lineFor(array|Arrayable $items, Closure $callback): static
    {
        $items = is_array($items) ? $items : $items->toArray();

        foreach ($items as $item) {
            $callback($this, $item);
        }

        return $this;
    }

    /**
     * Add a return statement, adding the semicolon.
     *
     * @return $this
     */
    public function return(string $return = ''): static
    {
        return $this->line("return {$return};");
    }

    /**
     * Append a semicolon to the last line.
     *
     * @return $this
     */
    public function finish(): static
    {
        $this->lines[count($this->lines) - 1] .= ';';

        return $this;
    }
}
