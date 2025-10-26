<?php

declare(strict_types=1);

use Honed\Data\Data\OptionData;

beforeEach(function () {});

it('creates data from option', function () {
    expect(OptionData::from([
        'label' => 'Test',
        'value' => 'test',
    ]))->toBeInstanceOf(OptionData::class);
});
