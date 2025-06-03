<?php

declare(strict_types=1);

namespace Honed\List\Concerns;

use Honed\List\Attributes\List;
use Honed\List\List;
use ReflectionClass;

/**
 * @template TList of \Honed\List\List
 *
 * @property-read string|null $list The class string of the list for this model.
 */
trait HasList
{
    /**
     * Get the list instance for the model.
     *
     * @return TList
     */
    public function list()
    {
        return $this->newList()
            ?? List::listForModel(static::class);
    }

    /**
     * Create a new list instance for the model.
     *
     * @return TList|null
     */
    protected static function newList()
    {
        if (isset(static::$list)) {
            return static::$list::make();
        }

        if ($list = static::getListAttribute()) {
            return $list::make();
        }

        return null;
    }

    /**
     * Get the list from the List class attribute.
     *
     * @return class-string<List>|null
     */
    protected static function getListAttribute()
    {
        $attributes = (new ReflectionClass(static::class))
            ->getAttributes(List::class);

        if ($attributes !== []) {
            $list = $attributes[0]->newInstance();

            return $list->getList();
        }

        return null;
    }
}
