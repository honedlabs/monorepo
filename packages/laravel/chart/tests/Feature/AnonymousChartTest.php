<?php

declare(strict_types=1);

use Honed\Chart\Axis\XAxis;
use Honed\Chart\Axis\YAxis;
use Honed\Chart\Chart;
use Honed\Chart\Series\Line\Line;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->users = User::factory(100)->create();
});

it('has chart', function () {
    // $chart = Chart::make()
    //     ->axes([XAxis::make(), YAxis::make()])
    //     ->series([
    //         Line::make('Name')->pluck('quantity')
    //     ])
    //     ->toolbox()
    //     ->legend()
    //     ->tooltip()
    //     ->colors();

    // dd(
    //     Chart::make($this->users)
    //         ->series([
    //             Line::make('Name')->pluck('name'),
    //         ])
    //         ->toArray()
    // );
});
