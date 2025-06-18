<?php

declare(strict_types=1);

namespace Honed\Infolist\Concerns;

use Honed\Infolist\Attributes\UseInfolist;
use Honed\Infolist\Infolist;
use ReflectionClass;

/**
 * @template TList of \Honed\Infolist\Infolist
 */
trait HasInfolist
{
    /**
     * The list instance for the model.
     *
     * @var TList|null
     */
    protected $list;

    /**
     * Get the infolist for the model.
     *
     * @return TList
     */
    public function toList()
    {
        return $this->infolist();
    }

    /**
     * Get the list instance for the model.
     *
     * @return TList
     */
    public function infolist()
    {
        return $this->newInfolist()
            ?? Infolist::infolistForModel($this);
    }

    /**
     * Get the list from the List class attribute.
     *
     * @return class-string<TList>|null
     */
    protected static function getUseInfolistAttribute()
    {
        $attributes = (new ReflectionClass(static::class))
            ->getAttributes(UseInfolist::class);

        if ($attributes !== []) {
            $list = $attributes[0]->newInstance();

            return $list->infolistClass;
        }

        return null;
    }

    /**
     * Create a new list instance for the model.
     *
     * @return TList|null
     */
    protected function newInfolist()
    {
        if (isset($this->list)) {
            return $this->list::make()->for($this);
        }

        if ($list = static::getUseInfolistAttribute()) {
            return $list::make()->for($this);
        }

        return null;
    }
}
