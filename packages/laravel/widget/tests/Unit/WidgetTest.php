<?php

declare(strict_types=1);

use Honed\Widget\WidgetServiceProvider;
use Workbench\App\Models\User;

use function Orchestra\Testbench\workbench_path;

beforeEach(function () {
    WidgetServiceProvider::setWidgetDiscoveryPaths([
        workbench_path('app/Widgets'),
    ]);
});

it('tests', function () {
    // dd(User::query()->get());
    // dd(app()->getCachedWidgetsPath());
    dd(app()->getCachedWidgetsPath());

    // Widget::for($user)->get();

    // Widget::for($user)->inertia();
});
