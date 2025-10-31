<?php

declare(strict_types=1);

use Honed\Core\Exceptions\PipeNotFoundException;
use Workbench\App\Pipes\SetType;

it('throws exception', function () {
    expect(function () {
        PipeNotFoundException::throw(SetType::class);
    })->toThrow(PipeNotFoundException::class);
});
