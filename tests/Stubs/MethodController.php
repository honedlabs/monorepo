<?php

declare(strict_types=1);

namespace Honed\Crumb\Tests\Stubs;

use Honed\Crumb\Concerns\Crumbs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MethodController extends Controller
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
