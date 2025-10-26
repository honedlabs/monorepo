<?php

declare(strict_types=1);

use Honed\Data\Data\FormData;
use Honed\Data\Exceptions\PartitionKeyNotSetException;

it('throws exception', function () {
    expect(function () {
        PartitionKeyNotSetException::throw('test', FormData::class);
    })->toThrow(PartitionKeyNotSetException::class);
});
