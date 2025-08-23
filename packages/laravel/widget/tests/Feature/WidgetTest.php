<?php

declare(strict_types=1);

use Honed\Widget\WidgetServiceProvider;
use Workbench\App\Models\User;

use function Orchestra\Testbench\workbench_path;

beforeEach(function () {
    WidgetServiceProvider::setWidgetDiscoveryPaths([
        workbench_path('app/Widgets'),
    ]);
})->only();

it('tests', function () {
    $this->artisan('widget:cache');
    // dd(User::query()->get());
    // dd(app()->getCachedWidgetsPath());
    dd(WidgetServiceProvider::getWidgetDiscoveryPaths());

    // Widget::for($user)->get();

    // Widget::for($user)->inertia();
});
