<?php

declare(strict_types=1);

namespace Honed\Table\Pipes;

use Honed\Core\Pipe;
use Honed\Table\Table;
use InvalidArgumentException;

/**
 * @template TClass of \Honed\Table\Table
 *
 * @extends Pipe<TClass>
 */
class Paginate extends Pipe
{
    /**
     * Run the after refining logic.
     *
     * @param  TClass  $instance
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function run($instance)
    {
        $paginate = $instance->getPaginate();

        $perPage = $this->getValue($instance);

        $key = $instance->getPageKey();

        $builder = $instance->getBuilder();

        switch ($paginate) {
            case Table::LENGTH_AWARE:
                $records = $builder->paginate($perPage, pageName: $key);

                $instance->setPagination($this->getLengthAwarePagination($records));
                $instance->setRecords($records->items());
                break;

            case Table::SIMPLE:
                $records = $builder->simplePaginate($perPage, pageName: $key);

                $instance->setPagination($this->getSimplePagination($records));
                $instance->setRecords($records->items());
                break;

            default:
                throw new InvalidArgumentException(
                    "The supplied paginate type [{$paginate}] is not supported."
                );

        }

    }
}
