<?php

declare(strict_types=1);

namespace Honed\Table;

use Honed\Table\Facades\Views;
use JsonSerializable;

class PendingViewInteraction
{
    /**
     * The view driver.
     *
     * @var \Honed\Table\Contracts\Driver
     */
    protected $driver;

    /**
     * The feature interaction scope.
     *
     * @var array<int, mixed>
     */
    protected $scope = [];

    /**
     * Create a new pending view interaction.
     *
     * @param \Honed\Table\Contracts\Driver $driver
     */
    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    /**
     * Set the scope for the pending view interaction.
     * 
     * @param mixed|array<int, mixed> $scope
     * @return $this
     */
    public function for($scope)
    {
        $scope = is_array($scope) ? $scope : func_get_args();

        $this->scope = [...$this->scope, ...$scope];

        return $this;
    }

    /**
     * Load the pending view interaction for the given table.
     * 
     * @param \Honed\Table\Table|class-string<\Honed\Table\Table> $table
     * @return object|null
     */
    public function load($table)
    {
        return $this->driver->list(Views::getTableName($table), $this->scope);
    }
}
