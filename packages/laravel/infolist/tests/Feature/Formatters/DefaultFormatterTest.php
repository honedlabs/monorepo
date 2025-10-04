<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\DefaultFormatter;

beforeEach(function () {
    $this->formatter = new DefaultFormatter();
});

it('passes through', function () {
    expect($this->formatter)
        ->format(null)->toBeNull()
        ->format('test')->toBe('test')
        ->format(123)->toBe(123);
});
