<?php

declare(strict_types=1);

use Honed\Data\Data\FormData;
use Honed\Data\Exceptions\DataClassNotSetException;

it('throws exception', function () {
    expect(function () {
        DataClassNotSetException::throw(FormData::class);
    })->toThrow(DataClassNotSetException::class);
});