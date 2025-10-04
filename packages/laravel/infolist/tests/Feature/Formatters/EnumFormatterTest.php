<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\EnumFormatter;
use Workbench\App\Enums\Status;

beforeEach(function () {
    $this->formatter = new EnumFormatter();
});

it('has enum', function () {
    expect($this->formatter)
        ->getEnum()->toBeNull()
        ->enum(Status::class)->toBe($this->formatter)
        ->getEnum()->toBe(Status::class);
});

it('handles null values', function () {
    expect($this->formatter)
        ->format(Status::ComingSoon)->toBeNull()
        ->enum(Status::class)->toBe($this->formatter)
        ->format(null)->toBeNull();
});

it('formats values', function () {
    expect($this->formatter)
        ->enum(Status::class)->toBe($this->formatter)
        ->format(Status::Available)->toBe(Status::Available)
        ->format('available')->toBe(Status::Available)
        ->format('other')->toBeNull();
});
