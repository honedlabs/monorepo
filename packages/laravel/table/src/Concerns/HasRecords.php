<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Illuminate\Support\Collection;

trait HasRecords
{
    /**
     * The records of the table retrieved from the resource.
     * 
     * @var \Illuminate\Support\Collection<array-key,array<array-key,mixed>>|null
     */
    protected $records = null;

    /**
     * Whether to reduce the records to only contain properties present in the columns.
     * 
     * @var bool
     */
    protected $reduce;

    /**
     * Whether to reduce the records to only contain properties present in the columns by default.
     * 
     * @var bool
     */
    protected static $defaultReduce = false;

    /**
     * Configure whether to reduce the records to only contain properties present in the columns by default.
     */
    public static function reduceRecords(bool $reduce = false): void
    {
        self::$defaultReduce = $reduce;
    }

    /**
     * Get the records of the table.
     *
     * @return \Illuminate\Support\Collection<int,array<string,mixed>>|null
     */
    public function getRecords(): ?Collection
    {
        return $this->records;
    }

    /**
     * Determine if the table has records.
     */
    public function hasRecords(): bool
    {
        return ! \is_null($this->records);
    }

    /**
     * Set the records of the table.
     * 
     * @param  \Illuminate\Support\Collection<int,array<string,mixed>>  $records
     */
    public function setRecords(Collection $records): void
    {
        $this->records = $records;
    }

    public function isReducing()
    {
        return match (true) {
            \property_exists($this, 'reduce') && !\is_null($this->reduce) => (bool) $this->reduce,
            \method_exists($this, 'reduce') => (bool) $this->reduce(),
            default => static::$defaultReduce,
        };
    }

    /**
     * Format the records using the provided columns.
     */
    public function formatRecords(Collection $activeColumns)
    {
        if (! $this->hasRecords()) {
            return;
        }



    }

}
