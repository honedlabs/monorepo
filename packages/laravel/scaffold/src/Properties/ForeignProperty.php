<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

class ForeignProperty extends Property
{
    /**
     * The type of the schema column.
     * 
     * @var string
     */
    protected $column = 'foreignId';

    /**
     * The strategy for when the foreign record is deleted.
     * 
     * @var ?string
     */
    protected $onDelete;

    public function suggest(): void
    {
        parent::suggest();
    }
}