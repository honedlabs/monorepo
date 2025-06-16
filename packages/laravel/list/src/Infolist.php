<?php

declare(strict_types=1);

namespace Honed\List;

use Honed\Core\Primitive;
use Honed\List\Entries\Entry;
use Illuminate\Database\Eloquent\Model;

class Infolist extends Primitive
{
    use Concerns\HasEntries;

    /**
     * The resource of the infolist.
     * 
     * @var array<string, mixed>|\Illuminate\Database\Eloquent\Model
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
     * @param  array<string, mixed>|\Illuminate\Database\Eloquent\Model  $resource
     * @return $this
     */
    public function for(array|Model $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get the instance as an array.
     */
    public function toArray($named = [], $typed = [])
    {
        return array_map(
            fn (Entry $entry) => $entry->build($this->resource),
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