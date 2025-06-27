<?php

declare(strict_types=1);

namespace Workbench\App\Responses\User;

use Honed\Honed\Responses\IndexResponse;
use Honed\Honed\Responses\InertiaResponse;

/**
 * @extends IndexResponse<UserTable>
 */
class IndexUser extends IndexResponse
{
    protected function definition(InertiaResponse $response): InertiaResponse
    {
        return $response;
    }
}