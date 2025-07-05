<?php

declare(strict_types=1);

use Honed\Stats\Overview;
use Honed\Stats\Stat;
use Illuminate\Support\Str;
use Workbench\App\Models\User;
use Workbench\App\Overviews\UserOverview;

beforeEach(function () {
    $this->overview = Overview::make();

    $this->user = class_basename(User::class);

    Overview::useNamespace('Workbench\\App\\Overviews\\');
});

afterEach(function () {
    Overview::flushState();
});

it('makes with stats', function () {
    expect(Overview::make([Stat::make('orders')]))
        ->toBeInstanceOf(Overview::class)
        ->getStats()->toHaveCount(1);
});

it('resolves overview for model', function () {
    expect(Overview::resolveOverview($this->user))
        ->toBeString()
        ->toBe(UserOverview::class);
});

it('gets overview for model', function () {
    expect(Overview::overviewForModel($this->user))
        ->toBeInstanceOf(UserOverview::class);
});

it('uses guess callback', function () {
    Overview::guessOverviewNamesUsing(fn (string $className) => Str::of($className)->classBasename()->value().'Overview');

    expect(Overview::resolveOverview(User::class))
        ->toBeString()
        ->toBe(class_basename(UserOverview::class));
});
