<?php

declare(strict_types=1);

namespace Honed\Crumb\Tests\Stubs;

use Honed\Crumb\Concerns\HasCrumbs;
use Illuminate\Http\Request;

class MethodController extends Controller
{
    use HasCrumbs;

    public function show(Request $request, Status $status)
    {
        return inertia('Status/Show', ['status' => $status]);
    }

    public function crumb()
    {
        return 'status';
    }
}
