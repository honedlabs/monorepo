<?php

declare(strict_types=1);

namespace Honed\List\Concerns;

use Honed\List\Attributes\List;
use Honed\List\Infolist;
use Honed\List\List;
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
            ?? List::listForModel($this);
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
            ->getAttributes(UseList::class);

        if ($attributes !== []) {
            $list = $attributes[0]->newInstance();

            return $list->listClass;
        }

        return null;
    }
}
