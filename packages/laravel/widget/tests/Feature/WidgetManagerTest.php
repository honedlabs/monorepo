<?php

declare(strict_types=1);

use App\Widgets\UserCountWidget;
use Honed\Widget\Facades\Widgets;

beforeEach(function () {
    $this->artisan('widget:cache');
});

it('makes', function () {
    expect(Widgets::make('count'))
        ->toBeInstanceof(UserCountWidget::class);

    expect(Widgets::make('missing'))
        ->toBeNull();
});
