<?php

declare(strict_types=1);

beforeEach(function () {});

it('tests', function () {
    $this->artisan('widget:clear');

    $this->artisan('widget:cache');

    // $this->artisan('widget:list');

    // Widget::for($user)->get();

    // Widget::for($user)->inertia();
});
