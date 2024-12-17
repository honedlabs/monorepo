<?php

declare(strict_types=1);

namespace Honed\Crumb\Tests\Stubs;

use Illuminate\Http\Request;
use Honed\Crumb\Attributes\Crumb;
use Honed\Crumb\Concerns\Crumbs;
use Honed\Crumb\Tests\Stubs\Product;
use Illuminate\Support\Facades\Route;

class MethodController
{
    use Crumbs;

    public function show(Request $request, Status $status)
    {
        return inertia('Status/Show', ['status' => $status]);
    }

    public function crumb()
    {
        return 'status';
    }
}
