<?php

declare(strict_types=1);

namespace Honed\Infolist;

use Honed\Core\Exceptions\ResourceNotSetException;
use Honed\Core\Primitive;
use Honed\Infolist\Entries\Entry;
use Illuminate\Database\Eloquent\Model;

class Infolist extends Primitive
{
    use Concerns\HasEntries;

    /**
     * The resource of the infolist.
     *
     * @var array<string, mixed>|Model
     */
    protected array|Model $resource;

    /**
     * Create a new infolist instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->definition($this);
    }

    /**
     * Set the resource of the infolist.
     *
     * @param  array<string, mixed>|Model  $resource
     * @return $this
     */
    public function for(array|Model $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get the resource to be used to generate the list.
     *
     * @return array<string, mixed>|Model
     */
    public function getResource(): array|Model
    {
        if (! $this->resource) {
            ResourceNotSetException::throw(static::class);
        }

        return $this->resource;
    }

    /**
     * Get the instance as an array.
     */
    public function toArray($named = [], $typed = [])
    {
        $resource = $this->getResource();

        return array_map(
            static fn (Entry $entry) => $entry
                ->record($resource)
                ->toArray(),
            $this->getEntries()
        );
    }

    /**
     * Define the infolist instance.
     *
     * @param  $this  $list
     * @return $this
     */
    protected function definition(self $list): self
    {
        return $list;
    }
}
