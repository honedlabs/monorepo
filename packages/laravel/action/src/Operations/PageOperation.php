<?php

declare(strict_types=1);

namespace Honed\Action\Operations;

class PageOperation extends Operation
{
    use Concerns\HandlesBulkActions;

    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->type(self::PAGE);
    }

    /**
     * Define the page operation instance.
     *
     * @param  $this  $operation
     * @return $this
     */
    protected function definition(self $operation): self
    {
        return $operation;
    }
}
