<?php

declare(strict_types=1);

namespace Workbench\App\Http\Responses;

use Honed\Honed\Responses\CreateResponse;

class CreateProduct extends CreateResponse
{
    /**
     * Define the response.
     * 
     * @return $this
     */
    protected function definition(): static
    {
        return $this;
    }
}
