<?php

declare(strict_types=1);

namespace Honed\Crumb\Tests\Stubs;

use Honed\Crumb\Concerns\HasCrumbs;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    use HasCrumbs;

    public $crumb = 'basic';

    public function show(Request $request, string $word)
    {
        return inertia('Word/Show', ['word' => $word]);
    }
}
