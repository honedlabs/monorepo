<?php

declare(strict_types=1);

namespace Honed\Crumb\Tests\Stubs;

use Illuminate\Http\Request;
use Honed\Crumb\Attributes\Crumb;
use Honed\Crumb\Concerns\Crumbs;
use Honed\Crumb\Tests\Stubs\Product;
use Illuminate\Support\Facades\Route;

class PropertyController
{
    use Crumbs;

    public $crumb = 'basic';

    public function show(Request $request, string $word)
    {
        return inertia('Word/Show', ['word' => $word]);
    }
}
