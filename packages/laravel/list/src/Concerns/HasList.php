<?php

declare(strict_types=1);

namespace Honed\List\Concerns;

use Honed\List\Attribute\UseInfolist;
use Honed\List\Attributes\UseList;
use Honed\List\Infolist;
use ReflectionClass;

/**
 * @template TList of \Honed\List\Infolist
 */
trait HasList
{
    /**
     * The list instance for the model.
     *
     * @var TList|null
     */
    protected $list;

    /**
     * Get the list instance for the model.
     *
     * @return TList
     */
    public function list(): Infolist
    {
        return $this->newList()
            ?? Infolist::listForModel($this);
    }

    /**
     * Create a new list instance for the model.
     *
     * @return TList|null
     */
    protected function newList(): ?Infolist
    {
        if (isset($this->list)) {
            return $this->list::make()->for($this);
        }

        if ($list = static::getListAttribute()) {
            return $list::make()->for($this);
        }

        return null;
    }

    /**
     * Get the list from the List class attribute.
     *
     * @return class-string<List>|null
     */
    protected static function getUseListAttribute(): ?string
    {
        $attributes = (new ReflectionClass(static::class))
            ->getAttributes(UseInfolist::class);

        if ($attributes !== []) {
            $list = $attributes[0]->newInstance();

            return $list->listClass;
        }

        return null;
    }
}
