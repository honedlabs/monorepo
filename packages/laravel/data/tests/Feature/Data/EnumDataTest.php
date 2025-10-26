<?php

declare(strict_types=1);

use App\Enums\Status;
use Honed\Data\Data\EnumData;
use Spatie\LaravelData\Exceptions\CannotCreateData;

beforeEach(function () {});

it('creates data from enum', function () {
    expect(EnumData::from(Status::Available))
        ->toBeInstanceOf(EnumData::class);
});

it('throws exception if not an enum', function () {
    EnumData::from('not an enum');
})->throws(CannotCreateData::class);