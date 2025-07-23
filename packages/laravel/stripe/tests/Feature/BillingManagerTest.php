<?php

declare(strict_types=1);

use Honed\Billing\Facades\Billing;

beforeEach(function () {

})->only();

it('test', function () {
    dd(Billing::driver()->first());
});