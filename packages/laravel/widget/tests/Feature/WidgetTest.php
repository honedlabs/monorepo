<?php

declare(strict_types=1);

use Honed\Widget\Facades\Widgets;
use Honed\Widget\WidgetServiceProvider;
use Workbench\App\Models\User;

use function Orchestra\Testbench\workbench_path;

beforeEach(function () {});

it('tests', function () {
    $this->artisan('widget:clear');

    $this->artisan('widget:cache');

    // $this->artisan('widget:list');

    // Widget::for($user)->get();

    // Widget::for($user)->inertia();
});
